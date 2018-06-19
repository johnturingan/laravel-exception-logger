<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 19/03/2018
 * Time: 5:35 PM
 */

namespace Snp\Logger\Traits;

use Snp\Logger\Utils\Request;
use Snp\Logger\Info;
use Snp\Logger\Utils\DeviceDetector;


/**
 * Trait PropsTrait
 * @package Snp\Logger\Traits
 */
trait PropsTrait
{

    /**
     * @var Request
     */
    protected $http_request;

    /**
     * Reference ID to be used application wide
     * @var string
     */
    protected $reference_id;

    /**
     * Requestor Platform
     * @var string
     */
    protected $platform;

    /**
     * Other Session Id
     * @var string
     */
    protected $session_id;

    /**
     * Member Id if Any
     * @var string
     */
    protected $member_id;

    /**
     * Country Code
     * @var string
     */
    protected $country_code;

    /**
     * Get Language code of the request
     * @var string
     */
    protected $language_code;

    /**
     * Request URL
     * @var string
     */
    protected $url;

    /**
     * Requestor Domain
     * @var string
     */
    protected $domain;

    /**
     * Requestor IP
     * @var string
     */
    protected $ip;

    /**
     * Request Body
     * @var array
     */
    protected $request_data;

    /**
     * Request Headers
     * @var array
     */
    protected $headers;

    /**
     * @return string
     */
    public function getLogType(): string
    {
        return $this->log_type;
    }

    /**
     * @return mixed
     */
    public function getReferenceId()
    {

        if ($this->reference_id) {

            return $this->reference_id;

        }

        //try header then cookie

        return $this->http_request
            ->header(config('logging.header_session'),
                $this->http_request
                    ->cookie(config('logging.cookie_session'))
            )
        ;


    }

    /**
     * @param $reference_id
     * @return $this
     */
    public function setReferenceId($reference_id)
    {
        $this->reference_id = $reference_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlatform()
    {

        if ($this->platform) {

            return $this->platform;

        }

        return DeviceDetector::deviceType();

    }

    /**
     * @param $platform
     * @return $this
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param $session_id
     * @return $this
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     * @param $member_id
     * @return $this
     */
    public function setMemberId($member_id)
    {
        $this->member_id = $member_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {

        if ($this->country_code) {

            return $this->country_code;

        }

        return $this->http_request
            ->header(config('logging.header_mapping.country_code'));
    }

    /**
     * @param $country_code
     * @return $this
     */
    public function setCountryCode($country_code)
    {
        $this->country_code = $country_code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguageCode()
    {

        if ($this->language_code) {

            return $this->language_code;

        }

        return $this->http_request
            ->get('acceptLanguage',
                $this->http_request->header('accept-language')
            );


    }

    /**
     * @param $language_code
     * @return $this
     */
    public function setLanguageCode($language_code)
    {
        $this->language_code = $language_code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {

        if ($this->url) {

            return $this->url;

        }

        return $this->http_request->url();
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {

        if ($this->domain) {

            return $this->domain;

        }

        return $this->http_request
            ->header(config('logging.header_mapping.domain'));
    }

    /**
     * @param $domain
     * @return $this
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {

        if ($this->ip) {

            return $this->ip;

        }

        return $this->http_request
            ->header(config('logging.header_mapping.ip'));
    }

    /**
     * @param $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestData()
    {

        if ($this->request_data) {

            return $this->request_data;

        }

        return $this->http_request->all();

    }

    /**
     * @param $request_data
     * @return $this
     */
    public function setRequestData($request_data)
    {
        $this->request_data = $request_data;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {

        if (! config('logging.include_headers_on_log')) return null;

        if ($this->headers) {

            return $this->headers;

        }

        return $this->http_request->header();
    }

    /**
     * @param $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Get All Data via Property Loop
     * @return array
     */
    public function getData ()
    {

        $data = [];

        foreach ($this as $key => $value) {

            $method = 'get' . ucfirst(camel_case($key));

            if (method_exists($this, $method)) {

                $data[$key] = $this->{$method}();

            }

        }

        $data['request_data'] = $this->hideProtectedFields($data['request_data']);

        return $data;
    }

    /**
     * @param $info Info
     * @return void
     */
    protected function populate ($info)
    {

        if ($info) {

            $info = $info->getData();

            foreach ($info as $key => $value) {

                $method = 'set' . ucfirst(camel_case($key));

                if (method_exists($this, $method)) {

                    $this->{$method}($value);

                }

            }

        }
    }

    /**
     * Hide all protected fields
     * @param $data
     * @return mixed
     */
    private function hideProtectedFields ($data)
    {

        if (empty($data)) return [];

        $protectedFields = config('logging.protected_fields');

        foreach ($protectedFields as $field)
        {
            if (isset($data[$field])) {

                if (is_array($data[$field])) {

                    foreach($data[$field] as $index => $value) {

                        $data[$field][$index] = $this->mask($value);
                    }

                } else {

                    $data[$field] = $this->mask($data[$field]);
                }
            }
        }

        return $data;

    }

    /**
     * Replace all string with *
     *
     * @param $string
     * @return string
     */
    private function mask($string)
    {
        return str_repeat("*", strlen($string));
    }

}