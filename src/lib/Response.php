<?php
namespace curl_spear\lib;

class Response implements CurlI
{
    private $code = null;
    private $data = [];
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
    }

    public function get($key = null)
    {
        // TODO: Implement get() method.
        return ($key === null) ?
            $this->data :
            (isset($this->data[$key]) === true ? $this->data[$key] : null);
    }

    public function delete($key)
    {
        // TODO: Implement delete() method.
    }

    public function clear()
    {
        $this->code = null;
        $this->data = [];
    }

    public function getCode()
    {
        return $this->code;
    }

    public function stringify()
    {

    }
}