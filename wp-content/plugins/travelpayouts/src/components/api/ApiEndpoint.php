<?php

namespace Travelpayouts\components\api;

use Travelpayouts;
use Travelpayouts\components\BaseObject;
use Travelpayouts\traits\SingletonTrait;

/**
 * Class ApiEndpoint
 * @package Travelpayouts\components\api
 *
 * @property-read array $responseData
 */
abstract class ApiEndpoint extends BaseObject
{
    use SingletonTrait;

    protected $_cacheTime = 3600;
    protected $_data = [];

    /**
     * @return array|mixed
     */
    public function getResponseData()
    {
        $cacheKey = $this->getCacheKey();
        if (!$cacheKey) return [];

        if (!$this->_data) {
            $cache = Travelpayouts::getInstance()->cache;
            $responseData = $cache->get($cacheKey);
            if ($responseData === false) {
                $responseData = $this->getApiResponseData();
                $cache->add($cacheKey, $responseData, $this->_cacheTime);
            }
            $this->_data = $responseData;
        }

        return $this->_data;
    }

    public function clearCache()
    {
        Travelpayouts::getInstance()->cache->delete($this->getCacheKey());
    }

    abstract protected function getCacheKey();

    abstract protected function getApiResponseData();
}
