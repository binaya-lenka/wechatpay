<?php

namespace Overnil\WechatPay;


class PaymentRequest
{

    use ParameterAwareTrait;

    const PARAM_APP_ID = 'appid';
    const PARAM_MCH_ID = 'mch_id';

    const PARAM_TRANSACTION_ID = 'transaction_id';
    const PARAM_OUT_TRADE_NO = 'out_trade_no';

    CONST PARAM_NONCE_STR = 'nonce_str';
    CONST PARAM_SIGN = 'sign';

    /**
     * The wechat instance.
     *
     * @var Wechat
     */
    protected $wechat;

    /**
     * PaymentRequest constructor.
     * @param Wechat $wechat
     * @param array $params
     */
    public function __construct(Wechat $wechat, array $params)
    {
        $this->wechat = $wechat;
        $this->params = $params;
    }

    /**
     * Prepare the xml that will be sent to wechat.
     *
     * @return string
     */
    protected function prepareXML()
    {
        $params = $this->params;
        $params[self::PARAM_APP_ID] = $this->wechat->getAppId();
        $params[self::PARAM_MCH_ID] = $this->wechat->getMchId();
        $params[self::PARAM_NONCE_STR] = $this->wechat->createNonceStr();
        $sign = $this->wechat->sign($params);
        $params[self::PARAM_SIGN] = $sign;
        return $this->wechat->createXML($params);
    }

    public function send()
    {
        $requestXML = $this->prepareXml();
        $responseXML = $this->wechat->getHttpClient()->executeHttpRequest('https://api.mch.weixin.qq.com/pay/orderquery', HttpClientInterface::METHOD_POST, $requestXML);
        $params = $this->wechat->createArrayFromXML($responseXML);
        if ($this->wechat->verify($params)) {
            return new PaymentResponse($params, $responseXML);
        } else {
            return false;
        }
    }

}