<?php
namespace curl_spear\lib;

use curl_spear\lib\interface_set\CurlI;

class Header implements CurlI
{
    private $data = [];

    public function __construct($userAgent)
    {
        $this->set('User-Agent', $userAgent);
    }

    public function set($key, $value = null)
    {
        // TODO: Implement set() method.
        $data = [];
        if ($value !== null) {
            $data[$key] = $value;
        } else {
            if (is_array($key) === false) {
                throw new \Exception('设置请求头错误：当仅传入一个参数时该参数必须为数组');
            }

            foreach ($key as $k => $v) {
                $data[$k] = $v;
            }
        }

        $this->data = array_merge($this->data, $data);
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
        unset($this->data[$key]);
    }

    public function clear()
    {
        $this->data = [];
    }
}