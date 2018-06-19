<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 21/03/2018
 * Time: 12:39 PM
 */
namespace Snp\Logger\Utils;


use Jenssegers\Agent\Agent;

/**
 * Class Agent
 * @package Snp\Logger\Utils
 */
class DeviceDetector
{

    /**
     * @var Agent
     */
    private static $agent;

    /**
     * @return Agent
     */
    private static function getAgentInstance ()
    {

        if (self::$agent) {

            return self::$agent;

        }

        return self::$agent = new Agent();

    }

    /**
     * Get Device Type
     * @return string
     */
    public static function deviceType ()
    {

        /**
         * @var $agent Agent
         */
        $agent = self::getAgentInstance();

        if ($agent->isMobile()) {

            /**
             * @var $request Request
             */
            $request = new Request();

            if ($request->header(config('logging.native_client_header'))) {

                return 'native';

            }

            return 'mobile';

        }

        return "desktop";
    }
}