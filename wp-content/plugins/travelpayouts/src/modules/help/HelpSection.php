<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\help;

use Travelpayouts;
use Travelpayouts\admin\redux\base\ModuleSection;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\components\HtmlHelper;
use Travelpayouts\components\LanguageHelper;

class HelpSection extends ModuleSection
{

    /**
     * @inheritdoc
     */
    public function section()
    {
        return [
            'title' => Travelpayouts::__('Help'),
            'icon' => 'el el-icon-question',
        ];
    }

    public function fields()
    {
        return [
			ReduxFields::raw('helpSection', HtmlHelper::tagArrayContent('div', [
				'style'=> 'margin: -15px -10px;'
			],   HtmlHelper::reactWidget('TravelpayoutsZendeskFeed', [
				'lang' => LanguageHelper::isRuDashboard()
					? 'ru'
					: 'en',
			]))),
        ];
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'help';
    }
}
