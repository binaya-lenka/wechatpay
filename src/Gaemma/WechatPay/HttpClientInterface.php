<?php

namespace Gaemma\WechatPay;


interface HttpClientInterface
{

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    /**
     * Make request.
     *
     * @param string $url
     * @param string $method
     * @param mixed $data
     * @return mixed
     * @throws Exception\HttpException
     */
    public function executeHttpRequest($url, $method = self::METHOD_GET, $data = []);

}