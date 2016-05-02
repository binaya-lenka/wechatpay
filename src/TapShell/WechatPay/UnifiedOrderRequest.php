<?php

namespace Overnil\WechatPay;


use Overnil\WechatPay\Exception\WechatPayException;

class UnifiedOrderRequest
{

    use ParameterAwareTrait;

    const TRADE_TYPE_JS_API = 'JSAPI';
    const TRADE_TYPE_NATIVE = 'NATIVE';
    const TRADE_TYPE_APP = 'APP';

    const PARAM_APP_ID = 'appid';
    const PARAM_MCH_ID = 'mch_id';
    const PARAM_BODY = 'body';
    const PARAM_OUT_TRADE_NO = 'out_trade_no';
    const PARAM_TOTAL_FEE = 'total_fee';
    const PARAM_SPBILL_CREATE_IP = 'spbill_create_ip';
    const PARAM_NOTIFY_URL = 'notify_url';
    const PARAM_TRADE_TYPE = 'trade_type';

    CONST PARAM_NONCE_STR = 'nonce_str';
    CONST PARAM_SIGN = 'sign';
    const PARAM_DEVICE_INFO = 'device_info';
    const PARAM_DETAIL = 'detail';
    const PARAM_ATTACH = 'attach';
    const PARAM_FEE_TYPE = 'fee_type';
    const PARAM_TIME_START = 'time_start';
    const PARAM_TIME_EXPIRE = 'time_expire';
    const PARAM_GOODS_TAG = 'goods_tag';
    const PARAM_PRODUCT_ID = 'product_id';
    const PARAM_LIMIT_PAY = 'limit_pay';
    const PARAM_OPENID = 'openid';

    /**
     * The wechat instance.
     *
     * @var Wechat
     */
    protected $wechat;

    /**
     * UnifiedOrder constructor.
     *
     * @param Wechat $wechat
     * @param array $params
     */
    public function __construct(Wechat $wechat, array $params = [])
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

    /**
     * Create wechat unified order.
     *
     * @return array|bool array the response params from wechat, or false when failed to creating the unified order.
     * @throws WechatPayException
     * @deprecated 1.0.0 Not recommended to use, and should be replaced by method "send()".
     */
    public function create()
    {
        $requestXML = $this->prepareXML();
        $responseXml = $this->wechat->getHttpClient()->executeHttpRequest('https://api.mch.weixin.qq.com/pay/unifiedorder', HttpClientInterface::METHOD_POST, $requestXML);
        $responseArray = $this->wechat->createArrayFromXML($responseXml);
        if (isset($responseArray['return_code']) && $responseArray['return_code'] === 'FAIL') {
            throw new WechatPayException($responseArray['return_msg']);
        }
        if ($this->wechat->verify($responseArray)) {
            return $responseArray;
        } else {
            return false;
        }
    }

    /**
     * Send wechat unified order request and create result instance.
     *
     * @return UnifiedOrderResponse unified order result.
     * @throws WechatPayException
     */
    public function send()
    {
        $xml = $this->prepareXML();
        $responseXml = $this->wechat->getHttpClient()->executeHttpRequest('https://api.mch.weixin.qq.com/pay/unifiedorder', HttpClientInterface::METHOD_POST, $xml);
        return new UnifiedOrderResponse($this->wechat->createArrayFromXML($responseXml), $responseXml);
    }

}