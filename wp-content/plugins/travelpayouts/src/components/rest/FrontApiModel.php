<?php

namespace Travelpayouts\components\rest;

use Travelpayouts;

/**
 * Class FrontApiModel
 * @package Travelpayouts\components\rest
 */
class FrontApiModel
{
    private $modulesClassList = [
        Travelpayouts\modules\tables\components\RestModule::class,
        Travelpayouts\modules\widgets\components\RestModule::class,
        Travelpayouts\modules\links\components\RestModule::class,
    ];

    /**
     * @var BaseRestModule[]
     */
    private $modulesInstanceList = [];

    /**
     * @return array
     */
    public function renderHome()
    {
        return [
            'modules' => $this->getRestModulesData(),
            'extraData' => [
                'translations' => $this->translations(),
            ],
        ];
    }

    /**
     * @return BaseRestModule[]
     */
    public function getRestModules()
    {
        if (empty($this->modulesInstanceList)) {
            $this->modulesInstanceList = array_map(function ($moduleClassName) {
                return new $moduleClassName;
            }, $this->modulesClassList);
        }
        return $this->modulesInstanceList;
    }

    /**
     * Получаем данные из модулей
     * @return mixed|null
     */
    protected function getRestModulesData()
    {
        $modules = $this->getRestModules();
        $result = [];

        foreach ($modules as $module) {
            $moduleName = $module->name;
            $result[$moduleName] = array_merge($module->data, ['name' => $moduleName]);
        }

        return $result;
    }

    /**
     * Дополнительные переводы
     * @return array
     */
    private function translations()
    {
        return [
            'button_title_save' => Travelpayouts::__('Save'),
            'button_title_cancel' => Travelpayouts::__('Cancel'),
            'select_title' => Travelpayouts::__('Select a program'),
            'button_title_setting' => Travelpayouts::__('Settings'),
            'shortcode_insert_failure' => Travelpayouts::__('An error occured while pasting the shortcode'),
        ];
    }
}
