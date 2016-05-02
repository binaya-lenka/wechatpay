<?php

namespace Overnil\WechatPay;


class PaymentResponse
{

    use ParameterAwareTrait;

    const RETURN_CODE_SUCCESS = 'SUCCESS';
    const RETURN_CODE_FAIL = 'FAIL';

    const RESULT_CODE_SUCCESS = 'SUCCESS';
    const RESULT_CODE_FAIL = 'FAIL';

    const TRADE_STATE_SUCCESS = 'SUCCESS';
    const TRADE_STATE_REFUND = 'REFUND';
    const TRADE_STATE_NOTPAY = 'NOTPAY';
    const TRADE_STATE_CLOSED = 'CLOSED';
    const TRADE_STATE_REVOKED = 'REVOKED';
    const TRADE_STATE_USERPAYING = 'USERPAYING';
    const TRADE_STATE_PAYERROR = 'PAYERROR';

    //

    const PARAM_RETURN_CODE = 'return_code';
    const PARAM_RETURN_MSG = 'return_msg';

    const PARAM_APP_ID = 'appid';
    const PARAM_MCH_ID = 'mch_id';

    CONST PARAM_NONCE_STR = 'nonce_str';
    CONST PARAM_SIGN = 'sign';

    const PARAM_RESULT_CODE = 'result_code';
    const PARAM_ERR_CODE = 'err_code';
    const PARAM_ERR_CODE_DES = 'err_code_des';

    const PARAM_DEVICE_INFO = 'device_info';
    const PARAM_OPENID = 'openid';
    const PARAM_IS_SUBSCRIBE = 'is_subscribe';
    const PARAM_TRADE_TYPE = 'trade_type';
    const PARAM_TRADE_STATE = 'trade_state';
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
    const PARAM_TRADE_STATE_DESC = 'trade_state_desc';


    /**
     * The wechat instance.
     *
     * @var Wechat
     */
    protected $wechat;

    /**
     * PaymentRequest constructor.
     * @param array $params
     * @param mixed $raw
     */
    public function __construct(array $params, $raw = null)
    {
        $this->params = $params;
        $this->raw = $raw;
    }

    /**
     * Get the return code, the return code can be "SUCCESS" or "FAIL".
     *
     * @return string
     */
    public function getReturnCode()
    {
        return $this->get(self::PARAM_RETURN_CODE);
    }

    /**
     * Check if the return code is success.
     *
     * @return bool
     */
    public function isReturnedCodeSuccess()
    {
        return $this->getReturnCode() === self::RETURN_CODE_SUCCESS;
    }

    /**
     * Get the return message.
     *
     * @return string
     */
    public function getReturnMsg()
    {
        return $this->get(self::PARAM_RETURN_MSG);
    }

    /**
     * Get the result code, the return code can be "SUCCESS" or "FAIL".
     *
     * @return string
     */
    public function getResultCode()
    {
        return $this->get(self::PARAM_RESULT_CODE);
    }

    /**
     * Check if the result code is success.
     *
     * @return bool
     */
    public function isResultCodeSuccess()
    {
        return $this->getResultCode() === self::RESULT_CODE_SUCCESS;
    }

    /**
     * Get the error code when result code is not "SUCCESS".
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->get(self::PARAM_ERR_CODE);
    }

    /**
     * Get the error message when result code is not "SUCCESS".
     *
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->get(self::PARAM_ERR_CODE_DES);
    }

    /**
     * Check if the return code and result code is "SUCCESS".
     *
     * @return bool
     */
    public function isOk()
    {
        return $this->isReturnedCodeSuccess() && $this->isResultCodeSuccess();
    }

    public function getTradeState()
    {
        return $this->get(self::PARAM_TRADE_STATE);
    }

    public function isTradeStateSuccess()
    {
        return $this->getTradeState() === self::TRADE_STATE_SUCCESS;
    }

}