<?php

namespace cmq2080\curl_spear\lib;

class Header
{
    protected $data;

    public function __construct($empty = false)
    {
        if (!$empty) {
            $this->set('Accept', '*/*');
            $this->set('Accept-Encoding', 'gzip,deflate');
            $this->set('Connection', 'Keep-Alive');
            $this->set('Content-Type', 'application/x-www-form-urlencoded;charset=utf-8');
        }
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }

    public function get($key, $default = null)
    {
        if (!$this->has($key)) {
            return $default;
        }
        return $this->data[$key];
    }

    public function getData()
    {
        $data = [];

        foreach ($this->data as $key => $value) {
            $data[] = $key . ': ' . $value;
        }

        return $data;
    }
}
