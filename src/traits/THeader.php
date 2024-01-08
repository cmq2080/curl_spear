<?php

namespace cmq2080\curl_spear\traits;

use cmq2080\curl_spear\lib\Header;

trait THeader
{
    protected $header;

    public function setHeader($header)
    {
        if (!($header instanceof Header)) {
            throw new \Exception('$header Is Not The Instance Of cmq2080\curl_spear\lib\Header');
        }
        $this->header = $header;

        return $this;
    }

    protected function checkHeader()
    {
        if (!isset($this->header)) {
            throw new \Exception('No Header Found');
        }
    }

    public function getHeader()
    {
        $this->checkHeader();

        return $this->header;
    }

    public function setHeaderValue($key, $value, $overwrite = true)
    {
        $this->checkHeader();

        if ($overwrite) {
            $this->header->set($key, $value);
        } else {
            $this->header->add($key, $value);
        }

        return $this;
    }

    public function getHeaderValue($key, $value = null)
    {
        return $this->header->get($key, $value);
    }

    public function hasHeaderKey($key)
    {
        $this->checkHeader();

        return $this->header->has($key);
    }
}
