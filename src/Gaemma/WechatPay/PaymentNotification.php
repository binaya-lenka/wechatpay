<?php

namespace Gaemma\WechatPay;


class PaymentNotification
{

    use ParameterAwareTrait;

    const RETURN_CODE_SUCCESS = 'SUCCESS';
    const RETURN_CODE_FAIL = 'FAIL';

    const RESULT_CODE_SUCCESS = 'SUCCESS';
    const RESULT_CODE_FAIL = 'FAIL';

    //

    const PARAM_RETURN_CODE = 'return_code';
    const PARAM_RETURN_MSG = 'return_msg';

    const PARAM_APP_ID = 'appid';
    const PARAM_MCH_ID = 'mch_id';

    const PARAM_DEVICE_INFO = 'device_info';
    CONST PARAM_NONCE_STR = 'nonce_str';
    CONST PARAM_SIGN = 'sign';

    const PARAM_RESULT_CODE = 'result_code';
    const PARAM_ERR_CODE = 'err_code';
    const PARAM_ERR_CODE_DES = 'err_code_des';

    const PARAM_OPENID = 'openid';
    const PARAM_IS_SUBSCRIBE = 'is_subscribe';
    const PARAM_TRADE_TYPE = 'trade_type';
    const PARAM_BANK_TYPE = 'bank_type';
    const PARAM_TOTAL_FEE = 'total_fee';
    const PARAM_FEE_TYPE = 'fee_type';
    const PARAM_CASH_FEE = 'cash_fee';
    const PARAM_CASH_FEE_TYPE = 'cash_fee_type';
    const PARAM_COUPON_FEE = 'coupon_fee';
    const PARAM_COUPON_COUNT = 'coupon_count';

    // todo
    const PARAM_COUPON_ID_PREFIX = 'coupon_id_';
    const PARAM_COUPON_FEE_PREFIX = 'coupon_fee_';

    const PARAM_TRANSACTION_ID = 'transaction_id';
    const PARAM_OUT_TRADE_NO = 'out_trade_no';
    const PARAM_ATTACH = 'attach';
    const PARAM_TIME_END = 'time_end';

    /**
     * The wechat instance.
     *
     * @var Wechat
     */
    protected $wechat;

    /**
     * NotifyVerifier constructor.
     *
     * @param Wechat $wechat
     * @param mixed $raw
     * @param array $params
     */
    public function __construct(Wechat $wechat, array $params, $raw = null)
    {
        $this->wechat = $wechat;
        $this->params = $params;
        $this->raw = $raw;
    }

    /**
     * Validate the params.
     *
     * @return bool
     */
    public function validate()
    {
        return $this->wechat->verify($this->params);
    }

}