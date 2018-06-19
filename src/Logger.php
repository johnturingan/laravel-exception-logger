<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 19/03/2018
 * Time: 2:23 PM
 */

namespace Snp\Logger;


use Monolog\Logger as MonoLogger;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 * @package Snp\Logger
 */
class Logger extends MonoLogger implements LoggerInterface
{

    /**
     * @param string $message
     * @param array $context
     * @return void
     */
    public function error($message, array $context = array())
    {

        if (config('logging.enable_graylog_logging')) {

            try {

                parent::error($message, $context);

            } catch (\Exception $e) {}

        }



        if (config('logging.enable_file_logging')) {

            $logger = app()->make('base-monolog');

            $logger->error($message, $context);

        }

    }

    /**\
     * @param string $message
     * @param array $context
     * @return void
     */
    public function info($message, array $context = array())
    {

        if (config('logging.enable_graylog_logging')) {

            try {

                parent::info($message, $context);

            } catch (\Exception $e) {}

        }


        if (config('logging.enable_file_logging')) {

            $logger = app()->make('base-monolog');

            $logger->info($message, $context);

        }

    }

}