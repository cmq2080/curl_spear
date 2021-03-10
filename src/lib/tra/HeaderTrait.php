<?php
/**
 * 描述：
 * Created at 2021/3/11 9:57 by 陈庙琴
 */

namespace curl_spear\lib\tra;


trait HeaderTrait
{
    public function setUserAgent($value)
    {
        $this->header->set('User-Agent', $value);
        return $this;
    }

    public function setHeaders($name, $value = null)
    {
        $this->header->set($name, $value);
        return $this;
    }

    public function getHeaders($name = null)
    {
        return $this->header->get($name);
    }

    public function deleteHeader($name)
    {
        $this->header->delete($name);
        return $this;
    }

    public function clearHeaders()
    {
        $this->header->clear();
        return $this;
    }
}