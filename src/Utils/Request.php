<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 20/04/2018
 * Time: 4:11 PM
 */

namespace Snp\Logger\Utils;

/**
 * Class Request
 * @package Snp\Logger\Utils
 */
class Request
{

    /**
     * @var array|mixed
     */
    private $headers = [];

    /**
     * @var array|mixed
     */
    private $cookies = [];

    private $requests = [];

    /**
     * Request constructor.
     */
    function __construct()
    {

        $this->headers = $this->get_from_native_php('headers');

        $this->cookies = $this->get_from_native_php('cookies');

        $this->requests = $this->get_from_native_php('requests');

    }

    /**
     * @return mixed
     */
    public function all()
    {

        return $this->requests;

    }

    /**
     * @param $key
     * @param string $default
     * @return string
     */
    public function get($key, $default = '')
    {

        return $this->requests[$key] ?? $default;
    }

    public function url()
    {
        return $_SERVER['REQUEST_URI'] ?? '';
    }

    /**
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    public function header($key = '', $default = '')
    {

        if (! $key) {

            return $this->headers;

        }

        return $this->headers[strtolower($key)] ?? $default;

    }

    /**
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    public function cookie($key, $default = '')
    {

        return $this->cookies[$key] ?? $default;

    }


    /**
     * @param $key
     * @return mixed
     */
    private function get_from_native_php ($key)
    {

        $handlers = [
            'headers' => function () {

                $headers = array ();

                foreach ($_SERVER as $name => $value)
                {
                    if (substr($name, 0, 5) == 'HTTP_')
                    {
                        $headers[str_replace(' ', '-', (strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
                return $headers;

            },
            'cookies' => function () {

                return $_COOKIE;

            },

            'requests' => function () {

                return $_REQUEST;

            }
        ];

        return $handlers[$key]();

    }

}