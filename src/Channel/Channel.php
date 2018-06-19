<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 15/03/2018
 * Time: 1:24 PM
 */

namespace Snp\Logger\Channel;

use Snp\Logger\Logger;


/**
 * Class Channel
 * @package Snp\Logger\Channel
 */
class Channel
{

    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {

        return app()->make(Logger::class);

    }


}