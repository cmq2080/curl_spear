<?php
/**
 * 描述：
 * Created at 2021/3/11 9:57 by 陈庙琴
 */

namespace curl_spear\lib\trait_set;


trait HeaderTrait
{
    public function setUserAgent($value)
    {
        $this->header->set('User-Agent', $value);
        return $this;
    }

    public function setHeader($name, $value = null) // 目的功能只是为了设置一个header项，所以用单数
    {
        $this->header->set($name, $value);
        return $this;
    }

    public function getHeader($name = null) // 目的功能只是为了获取一个header项，所以用单数
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