<?php

namespace SdV\Endpoint;

use Illuminate\Http\JsonResponse;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use SdV\Endpoint\ApiError;

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
            ->parseIncludes(request('include', []))
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
        return fractal($model, $transformer)
            ->parseIncludes(request('include', []))
            ->respond();
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
     * @param  array|ApiError|string
     * @param  array
     * @return Response
     */
    public function badRequest($error, array $headers = [])
    {
        return $this->error($error, 400, $headers);
    }

    /**
     * No valid API key provided.
     *
     * @param  array|ApiError|string
     * @param  array
     * @return Response
     */
    public function unauthorized($error, array $headers = [])
    {
        return $this->error($error, 401, $headers);
    }

    /**
     * Access forbidden.
     *
     * @param  array|ApiError|string
     * @param  array
     * @return Response
     */
    public function forbidden($error, array $headers = [])
    {
        return $this->error($error, 403, $headers);
    }

    /**
     * The requested resource doesn't exist.
     *
     * @param  array|ApiError|string
     * @param  array
     * @return Response
     */
    public function notFound($error, array $headers = [])
    {
        return $this->error($error, 404, $headers);
    }

    /**
     * The HTTP method is not allowed.
     *
     * @param  array|ApiError|string
     * @param  array
     * @return Response
     */
    public function methodNotAllowed($error, array $headers = [])
    {
        return $this->error($error, 405, $headers);
    }

    /**
     * The request sends invalid fields.
     *
     * @param  array|ApiError|string
     * @param  array
     * @return Response
     */
    public function unprocessableEntity($error, array $headers = [])
    {
        return $this->error($error, 422, $headers);
    }

    /**
     * Too many requests hit the API.
     *
     * @param  array|ApiError|string
     * @param  array
     * @return Response
     */
    public function tooManyRequests($error, array $headers = [])
    {
        return $this->error($error, 429, $headers);
    }

    /**
     * Something went wrong on API server.
     *
     * @param  array|ApiError|string
     * @param  array
     * @return Response
     */
    public function serverError($error, array $headers = [])
    {
        return $this->error($error, 500, $headers);
    }

    /**
     * Send an error response.
     *
     * @param  array|ApiError|string
     * @param  array
     * @return Response
     */
    public function error($error, $statusCode = 500, array $headers = [])
    {
        if ($error instanceof ApiError) {
            $error = $error->normalize();
        }

        if (is_string($error)) {
            $error = (new ApiError($statusCode, $error))->normalize();
        }

        return (new JsonResponse($error))->setStatusCode($statusCode)->withHeaders($headers);
    }
}
