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
                    'status' => '404',
                    'title' => $model.' not found.',
                ]
            ]);
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->notFound([
                'error' => [
                    'status' => '404',
                    'title' => 'Route not found ('.$request->method().': '.$request->path().').',
                ]
            ]);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->notFound([
                'error' => [
                    'status' => '404',
                    'title' => 'Unrecognized request URL ('.$request->method().': '.$request->path().').',
                ]
            ]);
        }
        if ($exception instanceof ValidationException) {
            $messages = $exception->validator->errors()->getMessages();

            $formattedErrors = [];
            foreach ($messages as $field => $error) {
                $formattedErrors[] = [
                    'field' => $field,
                    'details' => $error,
                ];
            }

            return $this->unprocessableEntity([
                'error' => [
                    'status' => '422',
                    'title' => 'Missing or invalid parameters.',
                    'messages' => $formattedErrors,
                ]
            ]);
        }

        return $this->serverError([
            'error' => [
                'status' => '500',
                'title' => 'Internal Server Error',
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
