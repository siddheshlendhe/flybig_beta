<?php

namespace Travelpayouts\modules\account;

use Travelpayouts;
use Travelpayouts\admin\redux\base\ModuleSection;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\components\Platforms;

class AccountForm extends ModuleSection
{
    public $api_token;
    public $api_marker;
    public $wl_domain;
    public $flights_domain;
    public $hotels_domain;
    public $platform;

    /**
     * @inheritdoc
     */
    public function section()
    {
        return [
            'title' => Travelpayouts::__('Account'),
            'icon' => 'el el-user',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            ReduxFields::text(
                'api_token',
                Travelpayouts::__('Your Travelpayouts API token'),
                '<a href="https://www.travelpayouts.com/programs/100/tools/api" target="_blank">' . Travelpayouts::__('Get API token and affiliate ID') . '</a>',
                Travelpayouts::__('Insert your API token')
            ),
            ReduxFields::text(
                'api_marker',
                Travelpayouts::__('Your Travelpayouts affiliate ID'),
                '',
                Travelpayouts::__('Insert your affiliate ID')
            ),
            ReduxFields::platformSelect(),
            ReduxFields::section_start(
                'wl_domain',
                Travelpayouts::__('Domain of your White Label'),
                Travelpayouts::__('Enter domain configured at Travelpayouts')
            ),
            ReduxFields::text(
                'flights_domain',
                Travelpayouts::__('Flights White Label')
            ),
            ReduxFields::text(
                'hotels_domain',
                Travelpayouts::__('Hotels White Label')
            ),
            ReduxFields::section_end(
                'wl_domain'
            ),
        ];
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'account';
    }
}
