<?php

namespace SdV\Endpoint;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use SdV\Endpoint\ApiError;
use SdV\Endpoint\ApiResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ProvidesExceptionsHandler
{
    use ApiResponse;

    public function renderJson(Exception $exception, Request $request)
    {
        if ($exception instanceof ModelNotFoundException) {
            $model = class_basename($exception->getModel());
            return $this->notFound($model.' not found.');
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->notFound('Route not found ('.$request->method().': '.$request->path().').');
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->methodNotAllowed('Unrecognized request URL ('.$request->method().': '.$request->path().').');
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

            $error = ApiError::unprocessableEntity('Missing or invalid parameters.', [
                'messages' => $formattedErrors,
            ]);

            return $this->unprocessableEntity($error);
        }

        return $this->serverError('Internal Server Error.');
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
