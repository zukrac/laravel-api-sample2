<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexCommentsRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * @OA\Post(
     *     path="/comments",
     *     tags={"Comments"},
     *     summary="Создать комментарий",
     *
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="content", type="string", description="Содержание комментария", example="Отличный продукт!"),
     *                  @OA\Property(property="commentable_type", type="string", description="Тип комментируемого объекта", example="App\\Models\\Product"),
     *                  @OA\Property(property="commentable_id", type="integer", description="ID комментируемого объекта", example=1),
     *                  @OA\Property(property="parent_id", type="integer", description="ID родительского комментария (для ответов)", example=null),
     *              ),
     *          ),
     *      ),
     *
     *     @OA\Response(
     *          response=201,
     *          description="Успешно создан",
     *          @OA\JsonContent(
     *              @OA\Property(property="comment", ref="#/components/schemas/CommentResource")
     *          )
     *      ),
     *     @OA\Response(response=422, description="Ошибка валидации"),
     * )
     *
     * @
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $comment = Comment::fill([
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
            'user_id' => $request->user()->id,
        ]);

        // Fill guarded data
        $comment->forceFill([
            'commentable_type' => $validated['commentable_type'],
            'commentable_id' => $validated['commentable_id'],
        ]);

        return response()->json([
            'comment' => CommentResource::make($comment),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/comments",
     *     tags={"Comments"},
     *     summary="Получить список комментариев",
     *
     *     @OA\Parameter(
     *         name="cursor",
     *         in="query",
     *         description="Курсор для пагинации",
     *         required=false,
     *         @OA\Schema(type="string", example="")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Количество элементов на странице (по умолчанию 15, максимум 100)",
     *         required=false,
     *         @OA\Schema(type="integer", example=15)
     *     ),
     *     @OA\Parameter(
     *         name="commentable_type",
     *         in="query",
     *         description="Тип комментируемого объекта для фильтрации",
     *         required=false,
     *         @OA\Schema(type="string", example="App\\Models\\Product")
     *     ),
     *     @OA\Parameter(
     *         name="commentable_id",
     *         in="query",
     *         description="ID комментируемого объекта для фильтрации",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="parent_id",
     *         in="query",
     *         description="ID родительского комментария для получения ответов",
     *         required=false,
     *         @OA\Schema(type="integer", example=null)
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Успешный ответ",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/CommentResource")),
     *              @OA\Property(property="next_cursor", type="string", description="Курсор для следующей страницы", nullable=true),
     *              @OA\Property(property="prev_cursor", type="string", description="Курсор для предыдущей страницы", nullable=true),
     *              @OA\Property(property="per_page", type="integer", description="Количество элементов на странице"),
     *          )
     *      ),
     * )
     */
    public function index(IndexCommentsRequest $request): JsonResponse
    {
        $query = Comment::with(['user', 'parent']);

        if ($request->filled('commentable_type') && $request->filled('commentable_id')) {
            $query->where('commentable_type', $request->input('commentable_type'))
                  ->where('commentable_id', $request->input('commentable_id'));
        }

        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->input('parent_id'));
        }

        $perPage = $request->input('per_page', 15);

        $paginator = $query->orderBy('created_at', 'desc')->cursorPaginate($perPage);

        return response()->json([
            'data' => CommentResource::collection($paginator->items()),
            'next_cursor' => $paginator->nextCursor()?->encode(),
            'prev_cursor' => $paginator->previousCursor()?->encode(),
            'per_page' => $paginator->perPage(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/comments/{id}",
     *     tags={"Comments"},
     *     summary="Получить комментарий по ID",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID комментария",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Успешный ответ",
     *          @OA\JsonContent(
     *              @OA\Property(property="comment", ref="#/components/schemas/CommentResource")
     *          )
     *      ),
     *     @OA\Response(response=404, description="Комментарий не найден"),
     * )
     */
    public function show(int $id): JsonResponse
    {
        $comment = Comment::with(['user', 'parent', 'replies'])->find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        return response()->json([
            'comment' => CommentResource::make($comment),
        ]);
    }

    /**
     * @OA\Put(
     *     path="/comments/{id}",
     *     tags={"Comments"},
     *     summary="Обновить комментарий",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID комментария",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="content", type="string", description="Содержание комментария", example="Обновленный текст комментария"),
     *              ),
     *          ),
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Успешно обновлен",
     *          @OA\JsonContent(
     *              @OA\Property(property="comment", ref="#/components/schemas/CommentResource")
     *          )
     *      ),
     *     @OA\Response(response=404, description="Комментарий не найден"),
     *     @OA\Response(response=422, description="Ошибка валидации"),
     * )
     */
    public function update(UpdateCommentRequest $request, int $id): JsonResponse
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $validated = $request->validated();

        $comment->update([
            'content' => $validated['content'],
        ]);

        return response()->json([
            'comment' => CommentResource::make($comment),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/comments/{id}",
     *     tags={"Comments"},
     *     summary="Удалить комментарий",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID комментария",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Успешно удален",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Comment deleted successfully")
     *          )
     *      ),
     *     @OA\Response(response=404, description="Комментарий не найден"),
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/comments/{id}/replies",
     *     tags={"Comments"},
     *     summary="Получить ответы на комментарий",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID родительского комментария",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Успешный ответ",
     *          @OA\JsonContent(
     *              @OA\Property(property="replies", type="array", @OA\Items(ref="#/components/schemas/CommentResource"))
     *          )
     *      ),
     *     @OA\Response(response=404, description="Комментарий не найден"),
     * )
     */
    public function replies(int $id): JsonResponse
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $replies = $comment->replies()->with('user')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'replies' => CommentResource::collection($replies),
        ]);
    }
}
