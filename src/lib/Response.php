<?php

namespace cmq2080\curl_spear\lib;

use cmq2080\curl_spear\traits\THeader;

class Response
{
    use THeader;

    protected $code;

    protected $content;

    public function __construct($result, $info)
    {
        // var_dump($result);
        // var_dump($info);
        $this->header = new Header(true);

        $this->code = $info['http_code'];
        $headerSize = $info['header_size'];

        $headerContent = substr($result, 0, $headerSize);
        $content = substr($result, $headerSize);

        $lines = explode("\n", $headerContent);
        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos($line, ': ') !== false) {
                [$key, $value] = explode(': ', $line, 2);
                $this->setHeaderValue($key, $value, false);
            }
        }

        if ($this->hasHeaderKey('Content-Encoding')) { // 有压缩
            $content = $this->decodeContent($content, $this->getHeaderValue('Content-Encoding'));
        }
        $this->content = $content;
    }

    protected function decodeContent($content, $contentEncoding)
    {
        if ($contentEncoding == 'gzip') {
            $content = gzdecode($content);
        }

        return $content;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function isSuccess()
    {
        $success = ($this->getCode() == 200);
        return $success;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getJsonData($key = null)
    {
        $json = json_decode($this->content, true);
        if ($json === null) {
            return null;
        }

        if ($key === null) {
            return $json;
        }

        // 序列化用的递归，反序列化用的迭代

        $key2s = array_filter(explode('.', $key));
        $targetData = $json;
        foreach ($key2s as $key2) {
            if (!isset($targetData[$key2])) { // Not Found
                $targetData = null;
                break;
            }

            $targetData = $targetData[$key2];
        }

        return $targetData;
    }
}
