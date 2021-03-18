<?php
/**
 * 描述：
 * Created at 2021/3/11 10:24 by 陈庙琴
 */

namespace curl_spear\lib\trait_set;


trait ResponseTrait
{
    public function getResponse()
    {
        return $this->response;
    }

    public function getResCode()
    {
        return $this->response->getCode();
    }

    public function getResData()
    {
        return $this->response->getData();
    }

    public function getResInfo($key = null)
    {
        return $this->response->getInfo($key);
    }
}