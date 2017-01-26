<?php

namespace Fab\Endpoint;

use Exception;
use Fab\Endpoint\ApiResponse;
use Fab\Endpoint\ApiError;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ProvidesExceptionsHandler
{
    use ApiResponse;

    public function renderJson(Exception $exception, Request $request)
    {
        if ($exception instanceof ModelNotFoundException) {
            $model = class_basename($exception->getModel());
            return $this->notFound(new ApiError($model.' not found.'));
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->notFound(new ApiError('Route not found ('.$request->method().': '.$request->path().')'));
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            $error = new ApiError('Unrecognized request URL ('.$request->method().': '.$request->path().')');
            return $this->notFound($error);
        }
        if ($exception instanceof ValidationException) {
            $messages = $exception->validator->errors()->getMessages();
            $error = (new ApiError('Unprocessable Entity'))->setData($messages);
            return $this->unprocessableEntity($error);
        }

        return $this->serverError(new ApiError('Internal Server Error'));
    }

    /**
     * Check if the request is for the API.
     *
     * @param  Request
     * @return boolean
     */
    public function isRequestForApi(Request $request)
    {
        return strpos($request->getUri(), '/api/') !== false || $request->expectsJson();
    }
}
