<?php

namespace cmq2080\curl_spear\lib;

use cmq2080\curl_spear\traits\THeader;

class Request
{
    use THeader;

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    // const METHOD_PUT = '';
    // const METHOD_DELETE = '';

    const ALLOWED_METHODS = [self::METHOD_GET, self::METHOD_POST];

    protected $url = null;

    protected $queryParams = [];

    protected $postData = [];

    public function __construct($header = null)
    {
        if ($header === null) {
            $header = new Header();
        }
        $this->setHeader($header); // 不能直接赋值，因为会跳过示例检测
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setQueryString($key, $value)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->setQueryString($k, $v);
            }
        } else {
            $this->queryParams[$key] = $value;
        }
        return $this;
    }

    public function setBody($key, $value)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->setBody($k, $v);
            }
        } else {
            $this->postData[$key] = $value;
        }
        return $this;
    }

    public function getAll()
    {
        $data = [];
        $data['Header'] = $this->header->getData();
        $data['QueryString'] = $this->queryParams;
        $data['Body'] = $this->postData;

        return $data;
    }
}
