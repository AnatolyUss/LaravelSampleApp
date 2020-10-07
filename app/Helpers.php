<?php

use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\DB;

if (!function_exists('runPaginatedQuery')) {
    /**
     * Run COUNT query using given Eloquent query builder.
     * !!!Notice, an exceptions handling must be accomplished by the caller.
     *
     * @param EloquentBuilder $builder
     * @param array $queryParameters
     * @return array
     */
    function runPaginatedQuery(EloquentBuilder $builder, array $queryParameters): array
    {
        $defaultQueryPageLimit = 5;
        $limit = isset($searchParameters['limit'])
            ? $queryParameters['limit']
            : env('DB_DEFAULT_QUERY_LIMIT', $defaultQueryPageLimit);

        $offset = isset($queryParameters['offset']) ? $queryParameters['offset'] : 0;
        $orderField = isset($queryParameters['orderField']) ? $queryParameters['orderField'] : 'id';
        $orderDirection = isset($queryParameters['orderDirection']) ? $queryParameters['orderDirection'] : 'asc';

        $clonedBuilder = clone $builder;
        $sqlCount = 'SELECT COUNT(1) AS count FROM(%s) AS data;';
        $rawSqlQuery = sprintf($sqlCount, $clonedBuilder->toRawSql());
        $countResult = DB::select($rawSqlQuery);

        $dataCollection = $builder
            ->orderBy($orderField, $orderDirection)
            ->limit($limit)
            ->offset($offset)
            ->get();

        return [
            'dataCount' => $countResult[0]->count,
            'dataCollection' => $dataCollection,
        ];
    }
}

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
    function wrapControllerAction(callable $actionCallback): JsonResponse
    {
        /**
         * Simplified exceptions handler.
         *
         * @param Exception $exception
         * @param int $statusCode
         * @return JsonResponse
         */
        $simplifiedExceptionHandler = function (\Exception $exception, int $statusCode): JsonResponse
        {
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
