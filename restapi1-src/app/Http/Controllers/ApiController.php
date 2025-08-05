<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanySearchRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

/**
 * @OA\OpenApi(
 *     openapi="3.0.0",
 *      info=@OA\Info(
 *          version="1.0.0",
 *       title="Base Backend API",
 *       description="Документация для API теста сервера.",
 *      ),
 *      security={
 *           {"accessToken" = {}}
 *      }
 *  )
 *
 * @OA\Server(
 *       url="/api/",
 * ),
 *
 */
class ApiController extends Controller
{
    /**
     * @OA\Post(path="/search",
     *     tags={"Search", "Company"},
     *     summary="Поиск по компаниям",
     *
     *     @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/x-www-form-urlencoded",
     *               @OA\Schema(
     *                   @OA\Property(property="token", type="string", description="Токен", example="hardcoded-token1"),
     *                   @OA\Property(property="q", type="string", description="Поиск по названию", example=""),
     *                   @OA\Property(property="latitude", type="string", description="Широта", example=""),
     *                   @OA\Property(property="longitude", type="string", description="Долгота", example=""),
     *                   @OA\Property(property="distance", type="string", description="Дистанция", example=""),
     *                   @OA\Property(property="offset", type="string", description="Офсет", example=""),
     *                   @OA\Property(property="limit", type="string", description="Лимит", example=""),
     *               ),
     *          ),
     *      ),
     *
     *     @OA\Response(response = 200, description = "Ответ",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="companies", type="array", @OA\Items(ref="#/components/schemas/CompanyResource"))
     *             ),
     *         ),
     *     ),
     * )
     *
     * @TODO Релизовать поиск
     */
    public function search(CompanySearchRequest $request)
    {
        $companies = Company::all();

        return CompanyResource::collection($companies);
    }

    /**
     * @OA\Get(path="/get",
     *     tags={"Company"},
     *     summary="Получение профиля компании",
     *     @OA\Parameter(name="token", @OA\Schema(type="string"), description="Токен", example="hardcoded-token1", required=true, in="query"),
     *     @OA\Parameter(name="id", @OA\Schema(type="integer"), description="ID компании", in="query"),
     *     @OA\Response(response = 200, description = "Ответ",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="company", ref="#/components/schemas/CompanyResource"),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function get(Request $request)
    {
        $company = Company::find($request->input('id'));
//        $company = Company::find(1);

        return response()->json(CompanyResource::make($company), 200);
    }
}
