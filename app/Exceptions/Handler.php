<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Exception|Throwable $e): JsonResponse
    {
        // if ($this->shouldReportToSlack($e)) {
        //     Notification::route('slack', config('services.slack.notifications.channel'))
        //         ->notify(new SlackNotify($e));
        // }
        $response = [
            'message' => $this->getMessage($e),
            'redirect' => false,
        ];

        if ($this->getStatusCode($e) == Response::HTTP_FORBIDDEN && $e->getMessage() != '') {
            $response['redirect'] = true;
        }

        return response()->json($response, $this->getStatusCode($e));
    }

    private function shouldReportToSlack($e): bool
    {
        $ignoredExceptions = [
            AuthenticationException::class,
            // 其他要忽略的異常
        ];

        return in_array(config('app.env'), ['production', 'beta']) && ! in_array(get_class($e), $ignoredExceptions);
    }

    private function getMessage($e): string
    {
        if ($e->getMessage() == '') {
            return match (true) {
                $e instanceof AuthorizationException => '無此權限，請洽管理者。',
                $e instanceof AuthenticationException => '您的登入已失效，請重新登入。',
                $e instanceof AccessDeniedHttpException => '此帳號已被停用。',
                default => $e->getMessage() ? $e->getMessage() : '系統遇到未預期的錯誤，請聯絡系統管理員或稍後重試。',
            };
        }

        return $e->getMessage();
    }

    private function getStatusCode($e): int
    {
        return match (true) {
            $e instanceof NotFoundHttpException, $e instanceof ModelNotFoundException, $e instanceof MethodNotAllowedHttpException => Response::HTTP_NOT_FOUND,
            $e instanceof AccessDeniedHttpException, $e instanceof AuthorizationException => Response::HTTP_FORBIDDEN,
            $e instanceof AuthenticationException => Response::HTTP_UNAUTHORIZED,
            $e instanceof ValidationException => Response::HTTP_UNPROCESSABLE_ENTITY,
            default =>  Response::HTTP_INTERNAL_SERVER_ERROR,
        };
    }

    /**
     * 1xx (資訊性狀態碼)
     * 2xx (成功狀態碼)
     * 3xx (重定向狀態碼)
     * 4xx (客戶端錯誤狀態碼)
     * 5xx (服務器錯誤狀態碼)
     */
    private function isValidHttpStatusCode($code): bool
    {
        return $code >= 100 && $code < 600;
    }
}
