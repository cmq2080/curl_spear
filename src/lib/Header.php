<?php

namespace cmq2080\curl_spear\lib;

class Header
{
    protected $data = [];

    public function __construct($empty = false)
    {
        if (!$empty) {
            $this->add([
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip,deflate',
                'Connection' => 'Keep-Alive',
                'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8'
            ]);
        }
    }

    public function add($key, $value = null)
    {
        if (!is_array($key) && !is_string($key)) {
            throw new \Exception('Invalid Key');
        }

        if (is_array($key)) {
            foreach ($key as $key2 => $value2) {
                $this->add($key2, $value2);
            }

            return $this;
        }

        if (is_array($value)) {
            foreach ($value as $value2) {
                $this->add($key, $value2);
            }
            return $this;
        }

        if (!is_string($value) && !is_numeric($value)) {
            throw new \Exception('Invalid Value');
        }

        $this->data[] = [$key, $value];

        return $this;
    }

    public function remove($key)
    {
        foreach ($this->data as $i => $row) {
            $name = $row[0];
            if ($name === $key) {
                unset($this->data[$i]);
            }
        }

        $this->data = array_values($this->data);

        return $this;
    }

    public function set($key, $value)
    {
        $this->remove($key);
        $this->add($key, $value);

        return $this;
    }

    public function has($key): bool
    {
        foreach ($this->data as $i => $row) {
            $name = $row[0];
            if ($name === $key) {
                return true;
            }
        }

        return false;
    }

    public function get($key = null, $default = null)
    {
        if ($key === null) {
            return $this->data;
        }

        if (!$this->has($key)) {
            return $default;
        }

        $value = [];
        foreach ($this->data as $i => $row) {
            $name = $row[0];
            if ($name === $key) {
                $val = $row[1];
                $value[] = $val;
            }
        }

        if (count($value) === 1) {
            $value = $value[0];
        }

        return $value;
    }

    public function getData()
    {
        $data = [];
        foreach ($this->data as $i => $row) {
            $name = $row[0];
            $value = $row[1];
            $item = $name . ':' . $value;

            $data[] = $item;
        }

        return $data;
    }
}
