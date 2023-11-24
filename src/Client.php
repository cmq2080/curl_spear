<?php

namespace cmq2080\curl_spear;

use cmq2080\curl_spear\lib\Request;
use cmq2080\curl_spear\lib\Response;

/**
 * @method void get($requestUrl = null, $params = [], $extends = [])
 * @method void post($requestUrl = null, $params = [], $extends = [])
 */
class Client
{
    protected static $instance;

    protected $request;
    protected $response;

    public static function instance($newInstance = false)
    {
        if ($newInstance) {
            return new static();
        }
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        $this->setRequest(new Request());
    }

    public function setRequest($request)
    {
        if (!($request instanceof Request)) {
            throw new \Exception('$request Is Not The Instance Of cmq2080\curl_spear\lib\Request');
        }

        $this->request = $request;

        return $this;
    }

    public function withJson()
    {
        $this->request->setHeaderValue('Content-Type', 'application/json;charset=utf-8');
        return $this;
    }

    public function getResponse()
    {
        if (!isset($this->response)) {
            return false;
        }
        return $this->response;
    }

    protected function run($method, $requestUrl = null, $params = [], $extends = [])
    {
        // Check Method
        $method = strtoupper($method);
        if (!in_array($method, Request::ALLOWED_METHOD)) {
            throw new \Exception('Method Is Not Allowed: ' . $method);
        }

        // 获取request并装载
        $request = $this->request;
        if ($method === 'GET') {
            $request->setQueryString($params, null);
        } else {
            $request->setBody($params, null);
        }
        $requestData = $request->getAll();
        // var_dump($requestData);

        // Check Request URL
        if (!$requestUrl) {
            $requestUrl = $request->getUrl();
        }
        if (!$requestUrl) {
            throw new \Exception('RequestUrl Not Found');
        }
        if ($requestData['QueryString']) {
            $requestUrl .= strpos($requestUrl, '?') === false ? '?' : '&';
            $requestUrl .= http_build_query($requestData['QueryString']);
        }

        // TODO
        $ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestData['Header']);
        if ($method !== 'GET') { // POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            $contentType = $request->getHeaderValue('Content-Type', 'application/x-www-form-urlencoded;charset=utf-8');
            $postData = http_build_query($requestData['Body']);
            if (strpos($contentType, 'application/json') !== false) {
                $postData = json_encode($requestData['Body']);
            }
            if (strpos($contentType, 'multipart/form-data') !== false) {
                $postData = $requestData['Body'];
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        foreach ($extends as $key => $value) {
            $curlOpt = 'CURLOPT_' . strtoupper($key);
            if (!defined($curlOpt)) {
                continue;
            }
            curl_setopt($ch, constant($curlOpt), $value);
        }

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $this->response = new Response($result, $info);

        curl_close($ch);
    }

    public function __call($name, $arguments)
    {
        $method = $name;
        $requestUrl = isset($arguments[0]) ? $arguments[0] : null;
        $params = isset($arguments[1]) ? $arguments[1] : [];
        $extends = isset($arguments[2]) ? $arguments[2] : [];
        $url = $this->run($method, $requestUrl, $params, $extends);
    }
}
