<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
     */
    public function search(CompanySearchRequest $request)
    {
        $query = Company::query();

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->input('q') . '%');
        }

        if ($request->filled('latitude') && $request->filled('longitude') && $request->filled('distance')) {
            $lat = $request->input('latitude');
            $lng = $request->input('longitude');
            $distance = $request->input('distance');

            $query->whereHas('address', function ($q) use ($lat, $lng, $distance) {
                $q->whereRaw("(
                    6371 * acos(
                        cos(radians(?)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) *
                        sin(radians(latitude))
                    )
                ) <= ?", [$lat, $lng, $lat, $distance]);
            });
        }

        if ($request->filled('offset')) {
            $query->offset($request->input('offset'));
        }

        if ($request->filled('limit')) {
            $query->limit($request->input('limit'));
        }

        $companies = $query->get();

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
