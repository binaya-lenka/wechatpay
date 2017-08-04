<?php

namespace Gaemma\WechatPay;


class UnifiedOrderResponse
{

    use ParameterAwareTrait;

    // CODE
    const RETURN_CODE_SUCCESS = 'SUCCESS';
    const RETURN_CODE_FAIL = 'FAIL';

    const RESULT_CODE_SUCCESS = 'SUCCESS';
    const RESULT_CODE_FAIL = 'FAIL';

    const PARAM_APP_ID = 'appid';
    const PARAM_MCH_ID = 'mch_id';

    const PARAM_RETURN_CODE = 'return_code';
    const PARAM_RETURN_MSG = 'return_msg';
    const PARAM_DEVICE_INFO = 'device_info';
    const PARAM_NONCE_STR = 'nonce_str';
    const PARAM_SIGN = 'sign';
    const PARAM_RESULT_CODE = 'result_code';
    const PARAM_ERR_CODE = 'err_code';
    const PARAM_ERR_CODE_DES = 'err_code_des';
    const PARAM_TRADE_TYPE = 'trade_type';
    const PARAM_PREPAY_ID = 'prepay_id';
    const PARAM_CODE_URL = 'code_url';

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
     * Get the response app id.
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->get(self::PARAM_APP_ID);
    }

    /**
     * Get the merchant id given by the wechat.
     *
     * @return string
     */
    public function getMchId()
    {
        return $this->get(self::PARAM_MCH_ID);
    }

    /**
     * Get the device info.
     *
     * @return string
     */
    public function getDeviceInfo()
    {
        return $this->get(self::PARAM_DEVICE_INFO);
    }

    /**
     * Get the nonce string.
     *
     * @return string
     */
    public function getNonceStr()
    {
        return $this->get(self::PARAM_NONCE_STR);
    }

    /**
     * Get the response sign.
     *
     * @return string
     */
    public function getSign()
    {
        return $this->get(self::PARAM_SIGN);
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

    /**
     * Get the trade type.
     *
     * @return string
     */
    public function getTradeType()
    {
        return $this->get(self::PARAM_TRADE_TYPE);
    }

    /**
     * Get the prepay id.
     *
     * @return string
     */
    public function getPrepayId()
    {
        return $this->get(self::PARAM_PREPAY_ID);
    }

    /**
     * Get the code url, this param is available when the trade_type is set to "NATIVE".
     *
     * @return string
     */
    public function getCodeUrl()
    {
        return $this->get(self::PARAM_CODE_URL);
    }

}