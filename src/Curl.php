<?php
/**
 * Created by PhpStorm.
 * User: mq
 * Date: 2019-07-26
 * Time: 09:48
 */

namespace curl_spear;


use curl_spear\lib\Body;
use curl_spear\lib\Header;
use curl_spear\lib\Response;
use curl_spear\lib\trait_set\BodyTrait;
use curl_spear\lib\trait_set\HeaderTrait;
use curl_spear\lib\trait_set\ResponseTrait;

class Curl
{
    use HeaderTrait;
    use BodyTrait;
    use ResponseTrait;

    // 默认的User-Agent
    const USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36  Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36 curl_spear/0.x';

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    private static $instance = null;
    private $config = null;
    private $header = null; // 请求头
    private $body = null; // 请求体
    private $response = null; // 响应结果

    public static function instance()
    {
        if (self::$instance === null || get_class(self::$instance) !== self::class) {
            // 没有则创建
            self::$instance = new self();
        } else {
            // 有则初始化header及body信息
            self::$instance->clearAll();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->header = new Header(self::USER_AGENT);
        $this->body = new Body();
        $this->response = null;
    }

    /**
     * 功能：清除请求及结果
     * Created at 2021/3/11 9:53 by 陈庙琴
     */
    public function clearAll()
    {
        $this->header->clear();
        $this->body->clear();
        $this->response = null;

        return $this;
    }

    /**
     * 功能：执行curl请求
     * Created By mq at 10:42 2019-07-26
     * @param $url
     * @param $method
     * @param array $data
     * @return bool|string
     * @throws \Exception
     */
    private function exec($url, $method)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, ($this->config->get('HEADER') !== null) ? $this->config->get('HEADER') : 0); // 头部不输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, ($this->config->get('RETURNTRANSFER') !== null) ? $this->config->get('RETURNTRANSFER') : 1); // 结果返回，不直接输出到页面
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, ($this->config->get('SSL_VERIFYPEER') !== null) ? $this->config->get('SSL_VERIFYPEER') : false); // 忽略证书验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, ($this->config->get('SSL_VERIFYHOST') !== null) ? $this->config->get('SSL_VERIFYHOST') : false); // 忽略证书验证

        $body = $this->body->get(); // 获取请求体数据
        if ($method === self::METHOD_GET) { // GET方式提交，拼接URL字符串
            if (empty($body) === false) { // 当请求体有数据时，续到url上
                $qString = http_build_query($body);
                $url = trim($url, '?');
                if (strpos($url, '?') !== false) { // 前面有参数了
                    $url .= '&' . $qString;
                } else { // 前面没有参数
                    $url .= '?' . $qString;
                }
            }

            curl_setopt($ch, CURLOPT_URL, $url);
        } else { // 非GET方式提交
            $this->header->set('X-HTTP-Method-Override', $method); // 设置提交方式①
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); // 设置提交方式②
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body); // 设置提交的数据
        }

        // 装配header
        $header = [];
        foreach ($this->header->get() as $key => $value) {
            $header[] = $key . ':' . $value;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // 执行
        $response = curl_exec($ch);

        if (curl_errno($ch)) { // 报错直接抛出异常
            throw new \Exception(curl_errno($ch) . ':' . curl_error($ch));
        }

        // 获取结果
        $responseInfo = curl_getinfo($ch);
        $this->response = new Response($responseInfo['http_code'], $response, $responseInfo);

        curl_close($ch);

        return $this->response;
    }

    /**
     * 功能：__call函数反射
     * Created By mq at 15:06 2019-08-06
     * @param $name
     * @param $arguments
     * @return bool|string
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        if (in_array(strtoupper($name), [self::METHOD_GET, self::METHOD_POST]) === true) {
            $url = $arguments[0];
            $method = strtoupper($name); // 这里是大写
            $data = isset($arguments[1]) ? $arguments[1] : [];
            if (is_array($data) === false) {
                $data = json_decode($data, true);
            }
            // 填充请求数据
            $this->body->set($data);

            return $this->exec($url, $method);
        }
    }
}