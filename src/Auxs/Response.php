<?php

namespace Cirel\LaravelBasicsAuxs\Auxs;

use Exception;
use Illuminate\Http\JsonResponse;
use function App\Auxs\response;

final class Response
{
    /**
     * @throws Exception
     */
    public static function successful(array $data, ?SuccessfulMessage $message = null, int $statusCode = 200, array|null $cookies = null): JsonResponse
    {
        if ($statusCode > 208) {
            throw new Exception("Status code out of range");
        }

        return Response::getResponse($data, $message, $statusCode, $cookies);
    }

    /**
     * @throws Exception
     */
    public static function error(ErrorMessage $message = null, array $data = [], int $statusCode = 500, array|null $cookies = null): JsonResponse
    {
        if ($statusCode < 400) {
            throw new Exception("Status code out of range");
        }

        return Response::getResponse($data, $message, $statusCode, $cookies);
    }

    private static function getResponse(array $data, ?Message $message, int $statusCode, array|null $cookies = null): JsonResponse
    {
        $objetMessage = $message ? ['message' => $message->toJson()] : [];
        $response = array_merge($data, $objetMessage);
        $response = response()->json($response, $statusCode);

        if ($cookies) {
            foreach ($cookies as $cookie) {
                $response->withCookie($cookie);
            }
        }

        return $response;
    }
}
