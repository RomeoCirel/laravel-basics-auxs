<?php

namespace Cirel\LaravelBasicsAuxs\Handlers;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Cirel\LaravelBasicsAuxs\Auxs\ValidationErrorMessage;
use Throwable;

class InvalidJsonResponseHandler extends ExceptionHandler
{
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {

        $rules = $exception->validator->getRules();
        $errors = [];

        foreach ($rules as $field => $validations) {
            $errors[$field] = [
                'isValid' => true,
                'error' => null
            ];
        }

        $validationErrors = $exception->errors();
        foreach ($validationErrors as $field => $message) {
            $errors[$field] = [
                'isValid' => is_null($message[0]),
                'error' => $message[0]
            ];
        }

        $message = new ValidationErrorMessage('Los datos enviados no son válidos', 'INVALID_DATA');

        return new JsonResponse(
            [
                'errors' => $errors,
                'message' => $message->toJson()
            ],
            $exception->status
        );
    }
}
