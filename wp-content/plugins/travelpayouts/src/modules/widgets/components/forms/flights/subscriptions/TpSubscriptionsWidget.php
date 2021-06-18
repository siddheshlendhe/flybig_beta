<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components\forms\flights\subscriptions;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\components\Translator;
use Travelpayouts\components\LanguageHelper;

use Travelpayouts\modules\widgets\components\forms\flights\Fields;

class TpSubscriptionsWidget extends Fields
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        $bgPalletFieldId = $this->optionPath . '_bg_pallet';

        return array_merge(
            [
                ReduxFields::accordion_start(
                    Travelpayouts::__('Flights. Subscribe to price changes.'),
                    Travelpayouts::__('Notifications about flights cost changes by direction based on a selected date/month')
                ),
                ReduxFields::widget_preview(
                    $this->optionPath,
                    ReduxFields::WIDGET_PREVIEW_TYPE_SCRIPT,
                    '//www.travelpayouts.com/subscription_widget/widget.js?backgroundColor={{fields.bg_pallet || "#2300b1"}}&marker=132474&host=hydra.aviasales.ru&originIata=MOW&originName=%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0&destinationIata=BKK&destinationName=%D0%91%D0%B0%D0%BD%D0%B3%D0%BA%D0%BE%D0%BA&powered_by=true'
                ),
            ],
            ReduxFields::width_toggle(
                $this->id,
                514,
                ReduxFields::get_ID(
                    $this->optionPath,
                    'scalling_width_toggle'
                )
            ),
            ReduxFields::flight_directions(),
            [
                [
                    'id' => 'pallets',
                    'type' => 'image_select',
                    'presets' => true,
                    'title' => Travelpayouts::__('Color scheme'),
                    'options' => [
                        '1' => [
                            'alt' => 'Preset 1',
                            'img' => ReduxFields::get_image_url('admin/widgets/flights/tp_subscriptions_widget/pallet_1.png'),
                            'presets' => [
                                $bgPalletFieldId => '#222222',
                            ],
                        ],
                        '2' => [
                            'alt' => 'Preset 1',
                            'img' => ReduxFields::get_image_url('admin/widgets/flights/tp_subscriptions_widget/pallet_2.png'),
                            'presets' => [
                                $bgPalletFieldId => '#98056A',
                            ],
                        ],
                        '3' => [
                            'alt' => 'Preset 1',
                            'img' => ReduxFields::get_image_url('admin/widgets/flights/tp_subscriptions_widget/pallet_3.png'),
                            'presets' => [
                                $bgPalletFieldId => '#00AFE4',
                            ],
                        ],
                        '4' => [
                            'alt' => 'Preset 1',
                            'img' => ReduxFields::get_image_url('admin/widgets/flights/tp_subscriptions_widget/pallet_4.png'),
                            'presets' => [
                                $bgPalletFieldId => '#74BA00',
                            ],
                        ],
                        '5' => [
                            'alt' => 'Preset 1',
                            'img' => ReduxFields::get_image_url('admin/widgets/flights/tp_subscriptions_widget/pallet_5.png'),
                            'presets' => [
                                $bgPalletFieldId => '#DB5521',
                            ],
                        ],
                        '6' => [
                            'alt' => 'Preset 1',
                            'img' => ReduxFields::get_image_url('admin/widgets/flights/tp_subscriptions_widget/pallet_6.png'),
                            'presets' => [
                                $bgPalletFieldId => '#FFBC00',
                            ],
                        ],
                        '7' => [
                            'alt' => 'Preset 1',
                            'img' => ReduxFields::get_image_url('admin/widgets/flights/tp_subscriptions_widget/pallet_7.png'),
                            'presets' => [
                                $bgPalletFieldId => '#DADADA',
                            ],
                        ],
                    ],
                ],
                ReduxFields::color(
                    'bg_pallet',
                    Travelpayouts::__('Color scheme custom'),
                    '',
                    '#2300b1'
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
        return 'tp_subscriptions_widget';
    }

    /**
     * @inheritDoc
     */
    public static function isActive()
    {
        return LanguageHelper::tableTranslatorLocale(false) === Translator::RUSSIAN;
    }
}
