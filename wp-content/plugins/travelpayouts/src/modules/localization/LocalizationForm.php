<?php

namespace Travelpayouts\modules\localization;

use Travelpayouts;
use Travelpayouts\admin\redux\base\ModuleSection;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\tables\components\flights\ColumnLabels as FlightsColumnLabels;
use Travelpayouts\modules\tables\components\hotels\ColumnLabels as HotelsColumnLabels;
use Travelpayouts\modules\tables\components\railway\ColumnLabels as RailwayColumnLabels;

/**
 * Class SettingsForm
 * @package Travelpayouts\src\modules\settings
 */
class LocalizationForm extends ModuleSection
{
    /**
     * @inheritdoc
     */
    public function section()
    {
        return [
            'title' => Travelpayouts::__('Localization'),
            'icon' => 'el el-cog',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge(
            [ReduxFields::accordion_start(Travelpayouts::__('Russian'))],
            $this->get_translation_fields('ru'),
            [ReduxFields::accordion_end()]
        );
    }

    private function get_translation_fields($lang)
    {
        $translations = [];

        $columns = [
            'flights' => FlightsColumnLabels::getInstance()->columnLabels(),
            'hotels' => HotelsColumnLabels::getInstance()->columnLabels(),
            'railway' => RailwayColumnLabels::getInstance()->columnLabels(),
        ];

        return [];
        // @TODO необходимо добавить совместимость с вышеуказанными в columns классами
//        foreach ($columns as $categoryName => $categoryColumns) {
//            $translations[] = array_map(function ($translatedKey, $translatedValue) use ($categoryName, $lang, $dictionary) {
//                $key = implode('_', [
//                    $categoryName,
//                    $translatedKey,
//                ]);
//                return ReduxFields::text(
//                    "{$key}_{$lang}",
//                    $translatedValue,
//                    '',
//                    '',
//                    $dictionary->getItem($key)->getName()
//                );
//            }, array_keys($categoryColumns), $categoryColumns);
//        }
//        return array_merge(...$translations);
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'localization';
    }
}
