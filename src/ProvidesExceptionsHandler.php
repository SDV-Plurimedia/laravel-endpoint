<?php

namespace SdV\Endpoint;

use Exception;
use SdV\Endpoint\ApiResponse;
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
            return $this->notFound([
                'error' => [
                    'message' => $model.' not found.',
                ]
            ]);
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->notFound([
                'error' => [
                    'message' => 'Route not found ('.$request->method().': '.$request->path().').',
                ]
            ]);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->notFound([
                'error' => [
                    'message' => 'Unrecognized request URL ('.$request->method().': '.$request->path().').',
                ]
            ]);
        }
        if ($exception instanceof ValidationException) {
            $messages = $exception->validator->errors()->getMessages();
            return $this->unprocessableEntity([
                'error' => [
                    'message' => 'Unprocessable Entity.',
                    'errors' => $messages,
                ]
            ]);
        }

        return $this->serverError([
            'error' => [
                'message' => 'Internal Server Error',
            ]
        ]);
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
