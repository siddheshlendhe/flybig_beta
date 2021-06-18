<?php

namespace Travelpayouts\components\links;

use DateTime;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Exception;
use Travelpayouts;
use Travelpayouts\components\ErrorHelper;
use Travelpayouts\components\HtmlHelper as Html;
use Travelpayouts\components\InjectedModel;
use Travelpayouts\components\Model;
use Travelpayouts\modules\account\Account;
use Travelpayouts\modules\settings\Settings;

/**
 * Class LinkModel
 */
abstract class LinkModel extends InjectedModel
{
    const TYPE_FLIGHTS = 1;
    const TYPE_HOTELS = 2;
    const LINK_MARKER = 'wpplugin_link';

    public $text_link;
    public $shortcode_name;

    /**
     * @Inject
     * @var Settings
     */
    protected $settingsModule;

    /**
     * @Inject
     * @var Account
     */
    protected $accountModule;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['text_link'], 'required'],
            [['shortcode_name', 'settings_module_data', 'account_module_data'], 'safe'],
        ]);
    }

    /**
     * Добавляет количесто дней из параметра $days к текущей дате
     * @param int $days
     * @param string $format
     * @return string
     */
    protected function date_time_add_days($days = 1, $format = 'Y-m-d')
    {
        try {
            $date_time = new DateTime();
            $date_time->modify('+' . $days . ' Day');

            return $date_time->format($format);
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * Формирование ссылки из параметра url и настроек
     * @param $url
     * @return string
     */
    protected function get_link_html($url)
    {
        if ($this->settingsModule->useRedirect) {
            $url = site_url(TRAVELPAYOUTS_TEXT_DOMAIN . '_redirect?' . $url);
        }

        $button_attributes = [
            'href' => $url,
        ];
        $settingsModuleData = $this->settingsModule->data;
        if ($settingsModuleData->get('nofollow')) {
            $button_attributes['rel'] = 'nofollow';
        }
        if ($settingsModuleData->get('target_url')) {
            $button_attributes['target'] = '_blank';
        }

        $button_attributes['class'] = TRAVELPAYOUTS_TEXT_DOMAIN . '-link';

        $html = Html::tag(
            'a',
            $button_attributes,
            $this->text_link
        );

        return $html;
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->has_errors()) {
            return ErrorHelper::render_errors(
                $this->shortcode_name,
                $this->getErrors()
            );
        }

        return $this->get_link_html($this->get_url());
    }

    abstract protected function get_url();
}
