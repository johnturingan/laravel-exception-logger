<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 20/03/2018
 * Time: 4:03 PM
 */

namespace Snp\Logger;

use Snp\Logger\Traits\PropsTrait;
use Snp\Logger\Utils\Request;

/**
 * Class Info
 * @package Snp\Logger
 */
class Info
{

    use PropsTrait;

    /**
     * @var Request
     */
    protected $http_request;

    /**
     * Info constructor.
     */
    function __construct()
    {
        $this->http_request = new Request();
    }

}