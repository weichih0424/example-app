<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;        //引用特徵
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    use ApiResponseTrait;   //使用特徵，類似將Trait撰寫的方法貼到這個類別中

    public function render($request, Throwable $exception)
    {
        if($request->expectsJson()){
            //1.Model 找不到資源(上個範例修改為以下程式)
            if($exception instanceof ModelNotFoundException){
                return $this->errorResponse(
                    '找不到資源',
                    Response::HTTP_NOT_FOUND
                );
            }
            //2.網站輸入錯誤(新增判斷)
            if($exception instanceof NotFoundHttpException){
                return $this->errorResponse(
                    '無法找到此網址',
                    Response::HTTP_NOT_FOUND
                );
            }
            //3.網址不允許該請求動詞(新增判斷)
            if($exception instanceof MethodNotAllowedException){
                return $this->errorResponse(
                    $exception->getMessage(),       //回傳例外內容的訊息
                    Response::HTTP_METHOD_NOT_ALLOWED
                );
            }
        }
        return parent::render($request, $exception);
    }
}
