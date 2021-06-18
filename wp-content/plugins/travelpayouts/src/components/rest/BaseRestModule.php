<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\rest;

use Travelpayouts\components\BaseInjectedObject;

/**
 * Class BaseRestModule
 * @package Travelpayouts\components\rest
 * @property-read array $data
 * @property-read RestRoute[] $routeList
 * @property-read string $name
 */
abstract class BaseRestModule extends BaseInjectedObject
{
    private $_campaignList = [];

    /**
     * Список классов кампаний входящих в модуль
     * @return string[]
     */
    abstract protected function campaignList();

    /**
     * @return string
     */
    abstract protected function id();

    /**
     * @return string
     */
    abstract protected function title();

    /**
     * @return FrontRestModule[]
     */
    protected function getCampaignModels()
    {
        if (empty($this->_campaignList)) {
            $this->_campaignList = array_map(function ($campaignClassName) {
                return new $campaignClassName;
            }, $this->campaignList());
        }
        return $this->_campaignList;
    }

    /**
     * Получаем список кампаний и свойства входящих в нее шорткодов
     * @return array
     */
    protected function getCampaigns()
    {
        return array_reduce($this->getCampaignModels(), static function ($accumulator, $campaignModel) {
            /**
             * @var FrontRestModule $campaignModel
             */
            $shortcodeList = $campaignModel->shortcodes;
            // Не выдаем кампанию, если шорткодов в ней нет
            return count($shortcodeList)
                ? array_merge($accumulator, [
                    $campaignModel->name => [
                        'id' => $campaignModel->id,
                        'shortcodes' => $campaignModel->shortcodes,
                    ],
                ])
                : $accumulator;
        }, []);
    }

    /**
     * Массив с дополнительными данными для эндпоинта
     * @return array[]
     */
    protected function getExtraData()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'title' => $this->title(),
            'campaigns' => $this->getCampaigns(),
            'extraData' => $this->getExtraData(),
        ];
    }

    /**
     * @return RestRoute[]
     */
    public function getRouteList()
    {
        return array_reduce($this->getCampaignModels(), function ($accumulator, $campaignModel) {
            /**
             * @var FrontRestModule $campaignModel
             */
            $routeList = $campaignModel->getRouteModelList();
            /**
             * Добавляем id модуля к каждому роуту
             */
            foreach ($routeList as $route) {
                $route->addRoutePart($this->id());
            }
            return array_merge($accumulator, $routeList);
        }, []);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->id();
    }
}
