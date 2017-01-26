<?php

namespace Fab\Endpoint;

use Fab\Endpoint\Contracts\ApiError as ApiErrorContract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Respond with a paginated list of resources.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function respondPaginate($paginator, $tranformer)
    {
        return fractal($paginator->getCollection(), $tranformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond();
    }

    /**
     * Respond to a valid request.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function respond($model, $transformer)
    {
        return fractal($model, $transformer)->respond();
    }

    /**
     * The resource was created successfully.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function respondCreated($model, $transformer)
    {
        return fractal($model, $transformer)->respond(function (JsonResponse $response) {
            $response->setStatusCode(201);
        });
    }

    /**
     * No Content Response.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function respondNoContent()
    {
        return (new JsonResponse())->setStatusCode(204);
    }

    /**
     * The request was unacceptable, often due to missing a required parameter.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function badRequest(ApiErrorContract $error, array $headers = [])
    {
        $error->setStatusCode(400);

        return $this->error($error, $headers);
    }

    /**
     * No valid API key provided.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function unauthorized(ApiErrorContract $error, array $headers = [])
    {
        $error->setStatusCode(401);

        return $this->error($error, $headers);
    }

    /**
     * The requested resource doesn't exist.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function notFound(ApiErrorContract $error, array $headers = [])
    {
        $error->setStatusCode(404);

        return $this->error($error, $headers);
    }

    /**
     * The request sends invalid fields.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function unprocessableEntity(ApiErrorContract $error, array $headers = [])
    {
        $error->setStatusCode(422);

        return $this->error($error, $headers);
    }

    /**
     * Too many requests hit the API.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function tooManyRequests(ApiErrorContract $error, array $headers = [])
    {
        $error->setStatusCode(429);

        return $this->error($error, $headers);
    }

    /**
     * Something went wrong on API server.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function serverError(ApiErrorContract $error, array $headers = [])
    {
        $error->setStatusCode(500);

        return $this->error($error, $headers);
    }

    /**
     * Send an error response.
     *
     * @param  array
     * @param  array
     * @return Response
     */
    public function error(ApiErrorContract $error, array $headers = [])
    {
        return (new JsonResponse($error->format()))
            ->setStatusCode($error->statusCode())
            ->withHeaders($headers);
    }
}
