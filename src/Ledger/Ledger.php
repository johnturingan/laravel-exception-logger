<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 19/03/2018
 * Time: 5:04 PM
 */

namespace Snp\Logger\Ledger;

use Snp\Logger\Utils\Request;
use Snp\Logger\Info;
use Snp\Logger\Logger;
use Snp\Logger\Traits\PropsTrait;

/**
 * Class UniLogLedger
 * @package Snp\Ledger
 */
class Ledger
{

    use PropsTrait;

    /**
     * Logging Type
     * @var string
     */
    protected $log_type = 'INFO';

    /**
     * @var Request
     */
    protected $http_request;

    /**
     * Short Message About the Transaction
     * @var string
     */
    protected $message;

    /**
     * UniLogLedger constructor.
     * @param Info|null $info
     */
    function __construct(Info $info = null)
    {

        $this->http_request = new Request();

        $this->populate($info);

    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }



    /**
     * Record Ledger
     * @return void
     */
    public function record ()
    {

        $data = $this->getData();;

        /**
         * @var $logger Logger
         */
        $logger = app('snp_e_log');

        $logger->info($this->getMessage(), $data);
    }
}