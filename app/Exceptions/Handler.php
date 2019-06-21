<?php

namespace App\Exceptions;

use App\Models\Model;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Watson\Validating\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            /** @var Model $model */
            $model = $exception->getModel();
            $model_name = $model::prefix();
            return jsend_error(trans("messages.models.errors.not_found", ['model' => $model_name]), 404);
        }


        if ($exception instanceof ValidationException)
            return jsend_fail($exception->errors(), 400, $exception->getMessage());

        if ($exception instanceof UnauthorizedException)
            return jsend_error($exception->getMessage(), 403);

        if ($exception instanceof QueryException) {
            switch ((integer)trim($exception->getCode())) {
                case 23000:
                    $message = "Record already exist";
                    break;
                default:
                    $message = $exception->getMessage();
                    break;
            }
            return jsend_fail(null, 400, $message);
        }

        if ($exception instanceof \Exception) {
            return jsend_error($exception->getMessage(), 500, null);
        }
        return parent::render($request, $exception);
    }
}
