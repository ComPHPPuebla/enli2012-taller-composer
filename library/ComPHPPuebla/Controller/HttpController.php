<?php
namespace ComPHPPuebla\Controller;

class HttpController
{
    /**
     * @var array
     */
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

}