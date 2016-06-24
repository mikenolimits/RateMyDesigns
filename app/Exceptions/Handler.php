<?php namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Drapor\Requests\Validation\FormValidationException;
use Response;
use Redirect;
use Request;

class Handler extends ExceptionHandler
{
    public $statusCode;


    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $url = $request->getHost();
        if ($e instanceof FormValidationException) 
        {

            if (str_contains($url, 'api')) {
                $validationErrors = $this->respondToValidation([
                    'error'       => $e->getMessageBag(),
                    'status_code' => 422
                ], 422);

                return $validationErrors;
            } else {
                //$request->attributes = $validationErrors;
                return Redirect::back()
                    ->withInput(Request::old())
                    ->withErrors($e->getMessageBag(), 'default');
            }
        }

        if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
            if (str_contains($url, 'api')) 
            {
                return $this->respondNotFound('The resource you are looking for does not exist');
            }
        }
        if($e->getCode() >= 500 ){
            \Log::info($e);
            return $this->respondWithError("Internal Error");
        }
        return parent::render($request, $e);
    }


    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, array $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' =>[
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }


    /**
     * @param $data
     * @param $statusCode
     * @param array $headers
     * @return mixed
     */
    public static function respondToValidation($data, $statusCode, array $headers = [])
    {
        return Response::json($data, $statusCode, $headers);
    }
    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
