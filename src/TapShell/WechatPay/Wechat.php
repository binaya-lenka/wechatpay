<?php

namespace Overnil\WechatPay;


class Wechat
{

    /**
     * The wechat payment app id.
     *
     * @var string
     */
    protected $appId;

    /**
     * The wechat merchant id.
     *
     * @var string
     */
    protected $mchId;

    /**
     * The secret key to sign and verify params.
     *
     * @var string
     */
    protected $key;

    /**
     * The http client to send http request.
     *
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * Wechat constructor.
     *
     * @param string $appId
     * @param string $mchId
     * @param string $key
     */
    public function __construct($appId, $mchId, $key)
    {
        $this->appId = $appId;
        $this->mchId = $mchId;
        $this->key = $key;
    }

    /**
     * Get the app id.
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Get the merchant id.
     *
     * @return string
     */
    public function getMchId()
    {
        return $this->mchId;
    }

    /**
     * Get the secret key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sign params.
     *
     * @param array $params
     * @return string
     */
    public function sign(array $params)
    {
        $params = array_filter($params);
        ksort($params, SORT_STRING);
        $combinedKeyAndValues = [];
        foreach ($params as $key => $value) {
            $combinedKeyAndValues[] = $key . '=' . $value;
        }
        $combinedKeyAndValues[] = ('key=' . $this->key);
        $combinedString = implode('&', $combinedKeyAndValues);
        return strtoupper(md5($combinedString));
    }

    /**
     * Verify the signed params.
     *
     * @param array $params
     * @return bool
     */
    public function verify(array $params)
    {
        if (!isset($params['sign'])) {
            return false;
        }
        $sign = $params['sign'];
        unset($params['sign']);
        $params = array_filter($params);
        ksort($params, SORT_STRING);
        return $this->sign($params) === $sign;
    }

    /**
     * Create xml from array params.
     *
     * @param array $params
     * @return string
     */
    public function createXML(array $params)
    {
        $xml = '<xml>';
        foreach ($params as $key => $value) {
            $xml .= '<' . $key . '>' . $value . '</' . $key . '>';
        }
        $xml .= '</xml>';
        return $xml;
    }

    /**
     * Create array from xml string.
     *
     * @param string $xml
     * @return array
     */
    public function createArrayFromXML($xml)
    {
        $xmlElem = @simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($xmlElem === false) {
            return [];
        }
        return array_map('strval', (array) $xmlElem);
    }

    /**
     * Get the http client.
     *
     * @return HttpClientInterface
     */
    public function getHttpClient()
    {
        if (!isset($this->httpClient)) {
            $this->httpClient = new CurlHttpClient();
        }
        return $this->httpClient;
    }

    /**
     * Set the http client.
     *
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Create random string.
     *
     * @return string
     */
    public function createNonceStr()
    {
        return uniqid() . mt_rand(10000, 99999);
    }

    /**
     * Build param string.
     *
     * @param array $params
     * @return string
     */
    public function combineParams($params)
    {
        $combined = [];
        foreach ($params as $key => $value) {
            $combined[] = $key . '=' . $value;
        }
        return implode('&', $combined);
    }

    /**
     * Create unified order request instance.
     *
     * @param $out_trade_no
     * @param $body
     * @param $total_fee
     * @param $spbill_create_ip
     * @param $notify_url
     * @param $trade_type
     * @return UnifiedOrderRequest
     */
    public function createUnifiedOrderRequest($out_trade_no, $body, $total_fee, $spbill_create_ip, $notify_url, $trade_type)
    {
        $params = compact('out_trade_no', 'body', 'total_fee', 'spbill_create_ip', 'notify_url', 'trade_type');
        return new UnifiedOrderRequest($this, $params);
    }

    /**
     * Create qrcode instance.
     *
     * @param string $product_id
     * @return Qrcode
     */
    public function createQrcode($product_id)
    {
        return new Qrcode($this, compact('product_id'));
    }

    public function createPaymentRequest($transaction_id = null, $out_trade_no = null)
    {
        $params = array_filter(compact('transaction_id', 'out_trade_no'));
        return new PaymentRequest($this, $params);
    }

    /**
     * Create payment notification instance by xml.
     *
     * @param string $xml
     * @return PaymentNotification
     */
    public function createPaymentNotification($xml)
    {
        return new PaymentNotification($this, $this->createArrayFromXML($xml), $xml);
    }

}