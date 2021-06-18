<?php

namespace Travelpayouts\modules\tables\components\settings;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;

/**
 * Class HotelSettingsSection
 * @package Travelpayouts\modules\tables\components\settings
 */
class HotelSettingsSection extends Fields
{
    public $use_booking_com = '0';
    public $theme;

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $themes = [
            'default-theme' => Travelpayouts::__('Default theme'),
            'red-button-table' => Travelpayouts::__('Bright theme with a red button'),
            'blue-table' => Travelpayouts::__('Light theme with a blue button'),
            'grey-salad-table' => Travelpayouts::__('Light theme with a light green button'),
            'purple-table' => Travelpayouts::__('Light theme with a purple button'),
            'black-and-yellow-table' => Travelpayouts::__('Dark theme with a yellow button'),
            'dark-and-rainbow' => Travelpayouts::__('Dark theme with a coral button'),
            'light-and-plum-table' => Travelpayouts::__('Light theme with a plum search column'),
            'light-yellow-and-darkgray' => Travelpayouts::__('Light theme with a dark search column'),
            'mint-table' => Travelpayouts::__('Light theme with a mint button'),
        ];

        return array_merge(
            [
                ReduxFields::accordion_start(
                    Travelpayouts::__('Hotels. Tables settings'),
                    '',
                    false
                ),
                ReduxFields::checkbox('use_booking_com', Travelpayouts::__('Redirect to Booking.com'), '', (bool)$this->use_booking_com),
                ReduxFields::get_images_select(
                    'theme',
                    Travelpayouts::__('Themes'),
                    '',
                    $themes,
                    array_rand($themes)
                ),
                ReduxFields::accordion_end(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'hotels';
    }
}
