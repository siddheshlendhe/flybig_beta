<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\admin\redux;

use Redux_Travelpayouts;
use Travelpayouts;
use Travelpayouts\components\Component;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\module\ModuleRedux;
use Travelpayouts\traits\SingletonTrait;

class OptionsInit extends Component
{
	use SingletonTrait;

	public $optName = TRAVELPAYOUTS_REDUX_OPTION;

	public function __construct()
	{
		if (class_exists('Redux_Travelpayouts')) {
			$this->registerExtensions();
			$this->attachHooks();
			$this->registerModuleSections();
		}
	}

	public function registerExtensions()
	{
		Redux_Travelpayouts::setExtensions($this->optName, Travelpayouts::getAlias('@admin/redux/extensions/'));
	}

	public function attachHooks()
	{
		$optName = $this->optName;
		add_action("redux_travelpayouts/page/$optName/form/before", [
			$this,
			'beforeRender',
		], 10, 1);
	}

	public function beforeRender()
	{
		echo $this->renderFeedbackForm();
	}

	/**
	 * Инициализируем формы из модулей
	 */
	protected function registerModuleSections()
	{
		foreach (Travelpayouts::getInstance()->reduxModules as $module) {
			if($module instanceof ModuleRedux){
				$module->registerSection();
			}
		}
	}

	protected function renderFeedbackForm()
	{
		$templates = Travelpayouts::getInstance()->template;
		$locale = LanguageHelper::userLocale(false);

		$isRuLocale = $locale === 'ru_RU';
		$currentUser = wp_get_current_user();

		return $templates->render('admin::feedbackButton', [
			'buttonTitle' => $isRuLocale
				? 'Сообщить о баге / оставить отзыв'
				: 'Report a bug / leave your feedback',
			'formId' => $isRuLocale
				? 'HiJ9Gz8U'
				: 'pKhiBqhm',
			'buttonParams' => [
				'wp_version' => get_bloginfo('version'),
				'php_version' => PHP_VERSION,
				'plugin_version' => defined('TRAVELPAYOUTS_VERSION')
					? TRAVELPAYOUTS_VERSION
					: '-',
				'domain' => home_url(),
				'plugin_locale' => $locale,
				'marker' => Travelpayouts::getInstance()->account->marker,
				'email' => $currentUser->user_email,
			],
		]);
	}
}
