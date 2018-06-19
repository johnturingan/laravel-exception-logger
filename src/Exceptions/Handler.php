<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 20/03/2018
 * Time: 3:46 PM
 */

namespace Snp\Logger\Exceptions;


use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Snp\Logger\Info;

/**
 * Class Handler
 * @package Snp\Logger\Exceptions
 */
class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the internal exception types that should not be reported.
     *
     * @var array
     */
    protected $internalDontReport = [];


    /**
     * Report or log an exception.
     *
     * @param  \Exception  $e
     * @return mixed
     *
     * @throws \Exception
     */
    public function report(\Exception $e)
    {

        if ($this->shouldntReport($e)) {
            return 0;
        }

        if ($e instanceof Exception) {

            return $e->report();

        }

        /**
         * @var $info Info
         */
        $info = $e->{'log_info'};

        try {

            (new Exception( '[' . ($e->{'app_fault'} ?? '') . ' Exception] ' .  $e->getMessage(), $e->getCode(), null, $info))

                ->setAppFault($e->{'app_fault'} ?? '')
                ->setErrorLineNumber($e->getLine())
                ->setErrorFile($e->getFile())
                ->report();

        } catch (\Exception $i) {

            parent::report($e);

        }


    }

    /**
     * Determine if the exception is in the "do not report" list.
     *
     * @param  \Exception  $e
     * @return bool
     */
    protected function shouldntReport(\Exception $e)
    {
        $dontReport = array_merge($this->dontReport, $this->internalDontReport);

        return ! is_null($this->iterateTruth($dontReport, function ($type) use ($e) {

            return $e instanceof $type;
        }));
    }

    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param $array
     * @param callable|null $callback
     * @param null $default
     * @return mixed
     */
    private function iterateTruth ($array, callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            if (empty($array)) {
                return value($default);
            }

            foreach ($array as $item) {
                return $item;
            }
        }

        foreach ($array as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return value($default);
    }
}