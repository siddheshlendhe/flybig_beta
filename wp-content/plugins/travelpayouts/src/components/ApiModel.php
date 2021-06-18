<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Exception;
use Travelpayouts;
use Travelpayouts\components\base\cache\Cache;
use Travelpayouts\components\httpClient\Client;

/**
 * Class ApiModel
 * @package Travelpayouts\src\components
 * @property-read array $api_data
 * @property array|null $response
 * @property-read array $debugData
 */
abstract class ApiModel extends InjectedModel
{
    const CACHE_TIME = 60 * 5;

    /**
     * @Inject
     * @var Cache
     */
    protected $cache;

    /**
     * Опции для httpClient\Client
     * @see getHttpClient()
     * @var array
     */
    protected $clientOptions = [
        'timeout' => 15,
        'headers' => [
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => '*',
        ],
    ];
    /**
     * @var array|null
     */
    protected $_response;
    /**
     * @var string[]
     */
    private $_requestList = [];

    /**
     * @return Client
     */
    protected function getHttpClient()
    {
        return new Client($this->clientOptions);
    }


    /**
     * @return string
     */
    protected function getRequestQueryString()
    {
        return '?' . http_build_query($this->attributes);
    }

    /**
     * @return string|null
     * @see getRequestQueryString()
     */
    protected function getRequestUrl()
    {
        return $this->endpointUrl()
            ? $this->endpointUrl() . $this->getRequestQueryString()
            : null;
    }

    /**
     * @param array|null $data
     */
    protected function setResponse($data)
    {
        $this->_response = $data;
    }

    /**
     * @return array|null
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Функция, которая будет отдавать данные от апи
     * @return array|mixed
     */
    abstract protected function request();

    /**
     * Возвращаем данные из апи попутно вызывая коллбеки
     * @return array|bool
     */
    final public function sendRequest()
    {
        $this->response = null;
        try {
            if ($this->validate()) {
                $this->response = $this->request();
                $this->afterRequest();
                $this->notifyErrors();
                return $this->response;
            } else {
                $this->notifyErrors();
            }
        } catch (Exception $e) {
            Travelpayouts::getInstance()->rollbar->error($e->getMessage(), [
                $this->attributes,
            ]);
        }
        return [];
    }

    /**
     * Коллбек, вызываемый после назначения $this->response
     * На этом этапе необходимо применять мутации для обогащения данных
     * @return void
     */
    protected function afterRequest()
    {
    }

    /**
     * Собираем корректный url с аттрибутами и отправляем запрос
     * @param $api_url
     * @return array|bool
     */
    protected function fetchApi()
    {
        return $this->fetchRemoteContent($this->getRequestUrl());
    }

    /**
     * @param $url
     * @return bool|false|mixed|null
     * @see getRequestUrl()
     */
    private function fetchRemoteContent($url)
    {
        $this->addRequestUrl($url);
        $cacheKey = 'remoteContent' . $url;
        $data = $this->cache->get($cacheKey);
        if ($data === false) {
            $response = $this->getHttpClient()->get($url);
            if (!$response->isError) {
                $data = $response->json;
                $this->cache->set($cacheKey, $data, self::CACHE_TIME);
            }
        }
        return $data;
    }

    /**
     * @param string|array $urlList
     */
    protected function addRequestUrl($urlList)
    {
        $value = !is_array($urlList)
            ? [$urlList]
            : $urlList;
        $this->_requestList = array_merge($this->_requestList, $value);
    }

    public function getDebugData()
    {
        return $this->_requestList;
    }

    /**
     * @return string
     */
    abstract protected function endpointUrl();
}
