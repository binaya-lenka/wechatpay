<?php

namespace Gaemma\WechatPay;


trait ParameterAwareTrait
{

    /**
     * The unified order request params.
     *
     * @var array
     */
    protected $params = [];

    protected $raw;

    /**
     * @return bool
     */
    public function hasRaw()
    {
        return !empty($this->raw);
    }

    /**
     * @return mixed
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param mixed $raw
     * @return $this
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
        return $this;
    }

    /**
     * Set a payment parameter.
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function set($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    public function get($name, $default = null)
    {
        return $this->has($name) ? $this->params[$name] : $default;
    }

    public function has($name)
    {
        return isset($this->params[$name]);
    }

    /**
     * Remove a payment parameter.
     *
     * @param string $name
     * @return $this
     */
    public function remove($name)
    {
        unset($this->params[$name]);
        return $this;
    }

    /**
     * Add multiple parameters.
     *
     * @param array $params
     * @return $this
     */
    public function add(array $params)
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function all()
    {
        return $this->params;
    }

}