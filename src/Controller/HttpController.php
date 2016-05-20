<?php
namespace ComPHPPuebla\Controller;

class HttpController
{
    /** @type array */
    protected $params;

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function getParam($key)
    {
        return isset($this->params[$key]) ? $this->params[$key] : null;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function setParam($key, $value)
    {
        $this->params[$key] = $value;
    }
}
