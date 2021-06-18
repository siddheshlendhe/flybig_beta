<?php

/**
 * The file that defines the core plugin class
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 * @link       http://www.travelpayouts.com/?locale=en
 * @since      1.0.0
 * @package    Travelpayouts
 * @subpackage Travelpayouts/includes
 */
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\Vendor\League\Plates\Engine;
use Travelpayouts\Vendor\Rollbar\RollbarLogger;
use Travelpayouts\admin\Admin;
use Travelpayouts\components\Assets;
use Travelpayouts\components\base\BasePluginCore;
use Travelpayouts\components\base\cache\Cache;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\Module;
use Travelpayouts\components\module\ModuleRedux;
use Travelpayouts\components\Moment;
use Travelpayouts\components\multilingual\MultiLang;
use Travelpayouts\components\rest\FrontRestRoutes;
use Travelpayouts\components\snowplow\Tracker;
use Travelpayouts\components\Translator;
use Travelpayouts\frontend\Frontend;
use Travelpayouts\includes\HooksLoader;
use Travelpayouts\includes\I18n;
use Travelpayouts\includes\ReduxConfigurator;
use Travelpayouts\includes\Router;
use Travelpayouts\modules\account\Account;
use Travelpayouts\modules\help\HelpModule;
use Travelpayouts\modules\links\Links;
use Travelpayouts\modules\localization\Localization;
use Travelpayouts\modules\searchForms\Search;
use Travelpayouts\modules\settings\Settings;
use Travelpayouts\modules\tables\Tables;
use Travelpayouts\modules\widgets\Widgets;

/**
 * The core plugin class.
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 * @since      1.0.0
 * @package    Travelpayouts
 * @subpackage Travelpayouts/includes
 * @author     travelpayouts < wpplugin@travelpayouts.com>
 * @property-read ModuleRedux[] $reduxModules
 */
class Travelpayouts extends BasePluginCore
{
	/**
	 * @Inject
	 * @var Tables
	 */
	public $tables;

	/**
	 * @Inject
	 * @var Widgets
	 */
	public $widgets;

	/**
	 * @Inject
	 * @var Search
	 */
	public $searchForms;

	/**
	 * @Inject
	 * @var Account
	 */
	public $account;

	/**
	 * @Inject
	 * @var Settings
	 */
	public $settings;

	/**
	 * @Inject
	 * @var Localization
	 */
	public $localization;

	/**
	 * @Inject
	 * @var Cache
	 */
	public $cache;

	/**
	 * @Inject
	 * @var Translator
	 */
	public $translator;

	/**
	 * @Inject
	 * @var Frontend
	 */
	public $frontend;

	/**
	 * @Inject
	 * @var Admin
	 */
	public $admin;

	/**
	 * @Inject
	 * @var FrontRestRoutes
	 */
	public $rest;

	/**
	 * @Inject
	 * @var RollbarLogger
	 */
	public $rollbar;

	/**
	 * @Inject
	 * @var ReduxConfigurator
	 */
	public $redux;

	/**
	 * @Inject
	 * @var Engine
	 */
	public $template;

	/**
	 * @Inject
	 * @var Tracker
	 */
	public $snowTracker;

	/**
	 * @Inject
	 * @var MultiLang
	 */
	public $multiLang;

	/**
	 * @Inject
	 * @var Links
	 */
	public $links;

	/**
	 * @Inject
	 * @var Router
	 */
	public $router;

	/**
	 * @Inject
	 * @var Assets
	 */
	public $assets;

	/**
	 * @Inject("name")
	 * @var string
	 */
	protected $plugin_name;

	/**
	 * @Inject("version")
	 * @var string
	 */
	protected $version;

	/**
	 * @Inject
	 * @var HooksLoader
	 */
	public $hooksLoader;

	/**
	 * @Inject
	 * @var I18n
	 */
	protected $i18n;

	/**
	 * @Inject
	 * @var HelpModule
	 */
	protected $helpModule;

	/**
	 * @Inject
	 * @var Moment
	 */
	public $moment;

	public function init()
	{
		$this->i18n->register();
		$this->translator->locale = LanguageHelper::tableLocale();
		$momentConfigurator = $this->moment;
		$momentConfigurator::setLocale($this->translator->locale);
		$this->assets->loader->setUpHooks();
		$this->admin->setUpHooks();
		$this->frontend->setUpHooks();
		$this->registerShortcodes();
		$this->rest->setUpHooks();
	}

	/**
	 * @inheritDoc
	 */
	protected function aliasList()
	{
		$uploadDir = wp_upload_dir();

		return [
			'@root' => TRAVELPAYOUTS_PLUGIN_PATH,
			'@data' => TRAVELPAYOUTS_PLUGIN_PATH . '/data',
			'@src' => TRAVELPAYOUTS_PLUGIN_PATH . '/src',
			'@config' => TRAVELPAYOUTS_PLUGIN_PATH . '/src/config',
			'@includes' => TRAVELPAYOUTS_PLUGIN_PATH . '/src/includes',
			'@admin' => TRAVELPAYOUTS_PLUGIN_PATH . '/src/admin',
			'@frontend' => TRAVELPAYOUTS_PLUGIN_PATH . '/src/frontend',
			'@assets' => TRAVELPAYOUTS_PLUGIN_PATH . '/assets',
			'@images' => TRAVELPAYOUTS_PLUGIN_PATH . '/images',
			'@webhome' => get_home_url(),
			'@webroot' => plugin_dir_url(TRAVELPAYOUTS_PLUGIN_PATH . '/src'),
			'@webadmin' => '@webroot/src/admin',
			'@uploads' => !$uploadDir['error']
				? $uploadDir['basedir'] . DIRECTORY_SEPARATOR . TRAVELPAYOUTS_PLUGIN_NAME
				: null,
			'@webuploads' => !$uploadDir['error']
				?
				$uploadDir['baseurl'] . DIRECTORY_SEPARATOR . TRAVELPAYOUTS_PLUGIN_NAME
				: null,
			'@runtime' => '@uploads',
			'@webImages' => '@webroot/images',
		];
	}

	/**
	 * @param $capability
	 * @return bool
	 */
	public function currentUserCan($capability)
	{
		return current_user_can($capability);
	}

	/**
	 * @return ModuleRedux[] | Module[]
	 */
	public function getReduxModules()
	{
		return [
			$this->tables,
			$this->widgets,
			$this->searchForms,
			$this->account,
			$this->settings,
			$this->helpModule,
			$this->links,
		];
	}

	protected function registerShortcodes()
	{
		foreach ($this->getReduxModules() as $module) {
			if (method_exists($module, 'registerShortcodes')) {
				$module->registerShortcodes();
			}
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->hooksLoader->run();
	}

	/**
	 * Translates the given message.
	 * @param string $id The message id (may also be an object that can be cast to string)
	 * @param array $parameters An array of parameters for the message
	 * @param string|null $domain The domain for the message or null to use the default
	 * @param string|null $locale The locale or null to use the default
	 * @return string The translated string
	 * @throws InvalidArgumentException If the locale contains invalid characters
	 */
	public static function t($id, array $parameters = [], $domain = null, $locale = null)
	{
		return self::getInstance()->translator->trans($id, $parameters, $domain, $locale);
	}

	/**
	 * Translates the given choice message by choosing a translation according to a number.
	 * @param string $id The message id (may also be an object that can be cast to string)
	 * @param int $number The number to use to find the index of the message
	 * @param array $parameters An array of parameters for the message
	 * @param string|null $domain The domain for the message or null to use the default
	 * @param string|null $locale The locale or null to use the default
	 * @return string The translated string
	 * @throws InvalidArgumentException If the locale contains invalid characters
	 */
	public static function tChoise($id, $number, array $parameters = [], $domain = null, $locale = null)
	{
		return self::getInstance()->translator->transChoice($id, $number, $parameters, $domain, $locale);
	}

	/**
	 * Получаем локаль из translator компонента
	 * @param bool $fallbackLocale - возвращает оригинальный код локали или код фоллбек языка
	 * @return mixed|string
	 */
	public static function locale($fallbackLocale = true)
	{
		$translator = self::getInstance()->translator;
		return $translator
			? $translator->getLocale($fallbackLocale)
			: Translator::ENGLISH;
	}
}
