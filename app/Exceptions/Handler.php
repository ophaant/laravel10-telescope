<?php

namespace App\Exceptions;

use App\Traits\APIResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use APIResponse;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function render($request, \Throwable $exception)
    {
        $response = $this->handleException($request, $exception);
        return $response;
    }

    public function handleException($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            Log::error($exception->getMessage());
            return self::error(config('response.unauthorized'), null, Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof OAuthServerException) {
            Log::error($exception->getMessage());
            return self::error(config('response.unauthenticated'), null, Response::HTTP_UNAUTHORIZED);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return self::error(config('response.method_not_allowed'), null, Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof NotFoundHttpException) {
            return self::error(config('response.not_found'), null, Response::HTTP_NOT_FOUND);
        }
        if ($exception instanceof ValidationException) {
            return self::error(config('response.validation_error'), $exception->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof \HttpException) {
            return self::error(config('response.http_exception'), $exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof \ParseError) {
            return self::error(config('response.internal_server_error'), $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof \PDOException) {
            return self::error(config('response.internal_server_error'), $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

//        if (config('app.debug')) {
//            return parent::render($request, $exception);
//        }

        return self::error(config('response.internal_server_error'), $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}
