<?php
namespace curl_spear\lib;

use curl_spear\lib\interface_set\CurlI;

class Response implements CurlI
{
    private $code = null;
    private $data = null; // 这里的data是字符串类型
    private $info = [];

    public function __construct($code, $data, $info = [])
    {
        $this->code = $code;
        $this->data = $data;
        $this->info = $info;
    }

    public function set($key, $value)
    {
        // TODO: Implement set() method.
        return;
    }

    public function get($key = null)
    {
        // TODO: Implement get() method.
        return $this->data;
    }

    public function delete($key)
    {
        // TODO: Implement delete() method.
    }

    public function clear()
    {
        $this->code = null;
        $this->data = null;
        $this->info = [];
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getInfo($key = null)
    {
        return $key === null ?
            $this->info :
            (isset($this->info[$key]) === true ? $this->info[$key] : null);
    }
}