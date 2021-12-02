<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *     version="1.0.0",
     *     title="ACDM v2.0 OpenApi",
     *     description="ACDM v2.0 OpenApi",
     *     @OA\Contact(
     *          email="satrya@freshcms.net"
     *     ),
     *     @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     *
     * @OA\Server(
     *     url=L5_SWAGGER_CONST_HOST,
     *     description="ACDM v2.0 OpenApi host server"
     * )
     *
     * @OA\SecurityScheme(
     *     securityScheme="apiKey",
     *     type="apiKey",
     *     name="Authorization",
     *     in="header"
     * )
     *
     * @OA\Parameter(
     *      name="timezone",
     *      parameter="timezone",
     *      in="header",
     *      description="timezone parameter",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          enum={"Asia/Qatar", "UTC"},
     *          default="UTC"
     *      )
     * )
     */
}
