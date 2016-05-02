<?php

namespace Overnil\WechatPay;


class Qrcode
{

    use ParameterAwareTrait;

    const PARAM_APP_ID = 'appid';
    const PARAM_MCH_ID = 'mch_id';

    const PARAM_PRODUCT_ID = 'product_id';

    CONST PARAM_NONCE_STR = 'nonce_str';
    CONST PARAM_SIGN = 'sign';
    CONST PARAM_TIMESTAMP = 'timestamp';

    /**
     * The wechat instance.
     *
     * @var Wechat
     */
    protected $wechat;

    /**
     * Qrcode constructor.
     * @param Wechat $wechat
     * @param array $params
     */
    public function __construct(Wechat $wechat, array $params)
    {
        $this->wechat = $wechat;
        $this->params = $params;
    }

    /**
     * Compose the qrcode url string.
     *
     * @return string
     */
    public function compose()
    {
        $params = $this->params;
        $params[self::PARAM_APP_ID] = $this->wechat->getAppId();
        $params[self::PARAM_MCH_ID] = $this->wechat->getMchId();
        $params[self::PARAM_TIMESTAMP] = time();
        $params[self::PARAM_NONCE_STR] = $this->wechat->createNonceStr();
        $params[self::PARAM_SIGN] = $this->wechat->sign($params);
        return 'weixin://wxpay/bizpayurl?' . $this->wechat->combineParams($params);
    }

}