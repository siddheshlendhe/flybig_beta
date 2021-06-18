<?php

namespace Travelpayouts\modules\linkForms;

use Travelpayouts;
use Travelpayouts\admin\redux\base\ModuleSection;

class LinksForm extends ModuleSection
{
    /**
     * @inheritdoc
     */
    public function section()
    {
        return [
            'title' => Travelpayouts::__('Link substitution'),
            'icon' => 'el el-link',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            [
                'id' => 'shortcodes',
                'type' => 'travelpayouts_links_forms',
                'title' => Travelpayouts::__('Here you can add referral links that need to be substituted for the given anchor 
                phrases. Anchor is case sensitive.'),
                'desc' => Travelpayouts::__('In this section, you can add shortcodes for search forms 
                configured in the admin panel of your Travelpayouts account (https://www.travelpayouts.com/tools/forms). 
                Detailed instructions are available here (https://travel-template.dist.ooo/search-form.html)'),
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'add_links';
    }
}
