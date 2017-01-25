<?php

namespace SdV\Larapi;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function respondPaginate($paginator, $tranformer)
    {
        return fractal($paginator->getCollection(), $tranformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond();
    }

    public function respond($model, $transformer)
    {
        return fractal($model, $transformer)->respond();
    }

    public function respondCreated($model, $transformer)
    {
        return fractal($model, $transformer)->respond(function (JsonResponse $response) {
            $response->setStatusCode(201);
        });
    }

    public function respondNoContent()
    {
        return (new JsonResponse())->setStatusCode(204);
    }
}
