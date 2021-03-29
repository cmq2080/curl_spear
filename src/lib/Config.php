<?php
/**
 * 描述：
 * Created at 2021/3/18 8:51 by 陈庙琴
 */

namespace curl_spear\lib;


use curl_spear\lib\interface_set\CurlI;

class Config implements CurlI
{
    private $data = [];

    /**
     * 功能：设置数据（包括添加和修改）
     * Created at 2021/3/11 9:26 by Temple Chan
     * @param $key
     * @param $value
     * @return void
     * @throws \Exception
     */
    public function set($key, $value)
    {
        // TODO: Implement set() method.
        $this->data[$key] = $value;
    }

    /**
     * 功能：获取数据（包括获取全部数据或某一项数据）
     * Created at 2021/3/11 9:26 by Temple Chan
     * @param $key
     * @return mixed
     */
    public function get($key = null)
    {
        // TODO: Implement get() method.
        return ($key === null) ?
            $this->data :
            (isset($this->data[$key]) === true ? $this->data[$key] : null);
    }

    /**
     * 功能：删除数据（删除特定项数据）
     * Created at 2021/3/11 9:26 by Temple Chan
     * @param $key
     * @return void
     */
    public function delete($key)
    {
        // TODO: Implement delete() method.
        unset($this->data[$key]);
    }

    /**
     * 功能：清空数据
     * Created at 2021/3/11 9:48 by 陈庙琴
     * @return void
     */
    public function clear()
    {
        // TODO: Implement clear() method.
        $this->data = [];
    }
}