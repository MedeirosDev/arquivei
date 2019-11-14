<?php

namespace App\Http\Controllers;

use App\Http\Resources\NfeResource;
use App\Models\NfeSuccesses;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *      title="API Integration service Arquivei",
 *      version="v1"
 * )
 *
 * @OA\SecurityScheme(
 *  description="Authorization API ID",
 *  type="apiKey",
 *  name="x-api-id",
 *  in="header",
 *  securityScheme="x-api-id"
 * )
 * @OA\SecurityScheme(
 *  description="Authorization API KEY",
 *  type="apiKey",
 *  name="x-api-key",
 *  in="header",
 *  securityScheme="x-api-key"
 * )
 */

 /**
 * Class NfeController
 * @package App\Http\Controllers
 */

class NfeController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"nfe"},
     *     summary="Return NFe",
     *     description="Return a object of NFe",
     *     path="/api/nfe/{access_key}",
     *     operationId="Nfe/show",
     *     @OA\Parameter(
     *          name="access_key",
     *          in="query",
     *          description="Access key for NFe",
     *          required=true,
     *          @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      security={
     *          "x-api-id",
     *          "x-api-key",
     *      },
     *     @OA\Response(response="200", description="Object of NFe"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="NFe not found"),
     * ),
     */
    public function show(string $access_key)
    {
        $nfe = NfeSuccesses::byAccessKey($access_key)->first();

        if ($nfe) {
            return response()->json(new NfeResource($nfe), Response::HTTP_OK);
        }

        return abort(404);
    }


    /**
     * @OA\Get(
     *     tags={"nfe"},
     *     summary="Download XML NFe",
     *     description="Download XML of NFe",
     *     path="/api/download/{access_key}",
     *     operationId="Nfe/download",
     *     @OA\Parameter(
     *          name="access_key",
     *          in="query",
     *          description="Access key for NFe",
     *          required=true,
     *          @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      security={
     *          "x-api-id",
     *          "x-api-key",
     *      },
     *     @OA\Response(response="200", description="Stream file xml with named is access key"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="NFe not found or XML not found"),
     * ),
     */
    public function download(string $access_key)
    {
        $nfe = NfeSuccesses::byAccessKey($access_key)->first();

        if ($nfe && Storage::disk('local')->exists($nfe->xml)) {
            return Storage::disk('local')->download($nfe->xml, "{$access_key}.xml");
        }

        return abort(404);
    }
}
