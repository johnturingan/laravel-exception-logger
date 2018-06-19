<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 19/03/2018
 * Time: 2:28 PM
 */

namespace Snp\Logger\Exceptions;

use Snp\Logger\Utils\Request;
use Snp\Logger\Info;
use Snp\Logger\Traits\PropsTrait;
use Psr\Log\LoggerInterface;
use Throwable;


/**
 * Class Exception
 * @package Snp\Logger\Exceptions
 */
class Exception extends \Exception
{

    use PropsTrait;

    /**
     * Logging Type
     * @var string
     */
    protected $log_type = 'EXCEPTION';

    /**
     * @var Request
     */
    protected $http_request;

    /**
     * Application Where the Error Thrown
     * @var string
     */
    protected $app_fault;

    /**
     * UniLogException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param Info $info
     */
    function __construct($message = "",
                         $code = 0,
                         Throwable $previous = null,
                         Info $info = null)
    {

        $this->populate($info);

        $this->http_request = new Request();

        parent::__construct($message, $code, $previous);
    }


    /**
     * @return mixed
     */
    public function getAppFault()
    {
        return $this->app_fault;
    }

    /**
     * @param $app_fault
     * @return $this
     */
    public function setAppFault($app_fault)
    {
        $this->app_fault = $app_fault;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->getCode();
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->getMessage();
    }

    /**
     * @return mixed
     */
    public function getErrorLineNumber()
    {
        return $this->line;
    }

    /**
     * @param $line
     * @return $this
     */
    public function setErrorLineNumber($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorFile()
    {
        return $this->file;
    }

    /**
     * @param $file
     * @return $this ;
     */
    public function setErrorFile($file)
    {
        $this->file = $file;

        return $this;
    }


    /**
     * Report Log
     * @return void
     */
    public function report ()
    {

        $data = $this->getData();

        /**
         * @var $logger LoggerInterface
         */
        $logger = app('snp_e_log');

        $logger->error($this->message, $data);

    }

}