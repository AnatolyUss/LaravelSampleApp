<?php

use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

if (!function_exists('wrapControllerAction')) {
    /**
     * Wraps given controller's method with the try-catch block.
     * Handles most frequent exceptions.
     *
     * !!!Notice:
     * 1. Following implementation, as it currently written, isn't intended for production use, because it is simplified.
     * 2. Exception messages are returned as is.
     *
     * @param callable $actionCallback
     * @return JsonResponse
     */
    function wrapControllerAction(callable $actionCallback): JsonResponse {
        $simplifiedExceptionHandler = function (\Exception $exception, int $statusCode): JsonResponse {
            return response()->json($exception->getMessage(), $statusCode);
        };

        try {
            return $actionCallback();
        } catch (ValidationException $exception) {
            return $simplifiedExceptionHandler($exception, 400);
        } catch (QueryException $exception) {
            return $simplifiedExceptionHandler($exception, 500);
        } catch (\Exception $exception) {
            return $simplifiedExceptionHandler($exception, 500);
        }
    }
}
