<?php
/**
 * 描述：
 * Created at 2021/3/11 9:00 by Temple Chan
 */
namespace curl_spear\lib;

interface CurlI
{
    /**
     * 功能：设置数据（包括添加和修改）
     * Created at 2021/3/11 9:26 by Temple Chan
     * @param $key
     * @param $value
     * @return void
     * @throws \Exception
     */
    public function set($key, $value);

    /**
     * 功能：获取数据（包括获取全部数据或某一项数据）
     * Created at 2021/3/11 9:26 by Temple Chan
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * 功能：删除数据（删除特定项数据）
     * Created at 2021/3/11 9:26 by Temple Chan
     * @param $key
     * @return void
     */
    public function delete($key);

    /**
     * 功能：清空数据
     * Created at 2021/3/11 9:48 by 陈庙琴
     * @return void
     */
    public function clear();
}