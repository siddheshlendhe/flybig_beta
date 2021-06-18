<?php

namespace Travelpayouts\modules\tables\components\settings;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\admin\redux\ReduxOptions;

class FlightsSettingsSection extends Fields
{

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
                    Travelpayouts::__('Flights. Tables settings'),
                    '',
                    false
                ),
                ReduxFields::checkbox('title_inline_css', Travelpayouts::__('Disable plugin title styles')),
                [
                    'id' => 'typography',
                    'type' => 'typography',
                    'title' => Travelpayouts::__('Header styles'),
                    'output' => ['h2.site-description'],
                    'units' => ReduxOptions::FONT_SIZE_UNIT,
                    'default' => [
                        'color' => '#333',
                        'font-weight' => '400',
                        'font-family' => 'Arial, Helvetica, sans-serif',
                        'font-size' => '22' . ReduxOptions::FONT_SIZE_UNIT,
                        'line-height' => '24' . ReduxOptions::FONT_SIZE_UNIT,
                        'text-align' => 'left'
                    ],
                    'subsets' => false,
                    'select2'=> ReduxFields::select2Options(),
                    'required' => [
                        ReduxFields::get_ID($this->optionPath, 'title_inline_css'),
                        'equals',
                        false,
                    ],
                ],
                [
                    'id' => 'title_custom_class',
                    'type' => 'text',
                    'title' => Travelpayouts::__('Title css class'),
                    'subtitle' => '',
                    'desc' => '',
                    'default' => '',
                    'required' => [
                        ReduxFields::get_ID($this->optionPath, 'title_inline_css'),
                        'equals',
                        true,
                    ],
                ],
                ReduxFields::get_images_select(
                    'theme',
                    Travelpayouts::__('Themes'),
                    '',
                    $themes,
                    array_rand($themes)
                ),
                ReduxFields::select(
                    'message_error_switch',
                    Travelpayouts::__('Empty answer received'),
                    [
                        ReduxOptions::HIDE_SHORTCODE => Travelpayouts::__('Hide the table'),
                        ReduxOptions::SHOW_MESSAGE => Travelpayouts::__('Show error message'),
                        ReduxOptions::SHOW_SEARCH_FROM => Travelpayouts::__('Show the search form'),
                    ],
                    'hide',
                    Travelpayouts::__('Sometimes our cache doesn\'t contain relevant data for the request you have sent. In such cases, you can see what users will see.')
                ),
                ReduxFields::error_message(
                    $this->createFieldId('message_error_switch'),
                    Travelpayouts::__('Unfortunately, we don\'t have actual data for flights from {origin} to {destination}. [link title="Find tickets from {origin} to {destination}"]')
                ),
                ReduxFields::search_form_select(
                    $this->createFieldId('message_error_switch'),
                    'empty_flights_table_search_form'
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
        return 'flights';
    }
}
