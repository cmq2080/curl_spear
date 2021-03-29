<?php
/**
 * 描述：
 * Created at 2021/3/11 10:23 by 陈庙琴
 */

namespace curl_spear\lib\trait_set;


trait ConfigTrait
{
    public function setConfig($name, $value = null)
    {
        $this->config->set($name, $value);
        return $this;
    }

    public function getConfig($name = null)
    {
        return $this->config->get($name);
    }

    public function deleteConfig($name)
    {
        $this->config->delete($name);
        return $this;
    }
}