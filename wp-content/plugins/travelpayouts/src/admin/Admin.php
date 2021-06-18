<?php

/**
 * The admin-specific functionality of the plugin.
 * @link       http://www.travelpayouts.com/?locale=en
 * @since      1.0.0
 * @package    Travelpayouts
 * @subpackage Travelpayouts/admin
 */

namespace Travelpayouts\admin;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Exception;
use Travelpayouts\Vendor\Rollbar\RollbarLogger;
use RuntimeException;
use Travelpayouts;
use Travelpayouts\admin\components\landingPage\LandingModel;
use Travelpayouts\admin\controllers\WidgetPreviewController;
use Travelpayouts\admin\partials\LandingPage;
use Travelpayouts\admin\redux\OptionsInit;
use Travelpayouts\components\Assets;
use Travelpayouts\components\BaseInjectedObject;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\Menu;
use Travelpayouts\components\notices\Notices;
use Travelpayouts\components\notices\Notice;
use Travelpayouts\components\notices\NoticeButton;
use Travelpayouts\components\Platforms;
use Travelpayouts\components\snowplow\Tracker;
use Travelpayouts\helpers\ArrayHelper;
use Travelpayouts\includes\HooksLoader;
use Travelpayouts\includes\migrations\Migration;
use Travelpayouts\includes\ReduxConfigurator;
use Travelpayouts\modules\account\Account;

/**
 * The admin-specific functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * @package    Travelpayouts
 * @subpackage Travelpayouts/admin
 * @author     travelpayouts < wpplugin@travelpayouts.com>
 */
class Admin extends BaseInjectedObject
{
	/**
	 * The ID of this plugin.
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 * @Inject("name")
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 * @Inject("version")
	 */
	protected $version;

	/**
	 * @Inject("snowplow.context")
	 * @var array
	 */
	protected $snowPlowContext;

	/**
	 * @Inject
	 * @var RollbarLogger
	 */
	public $rollbar;
	/**
	 * @Inject
	 * @var Tracker
	 */
	public $snowTracker;
	/**
	 * @Inject
	 * @var Assets
	 */
	public $assets;

	/**
	 * @Inject
	 * @var HooksLoader
	 */
	protected $hooksLoader;

	/**
	 * @Inject
	 * @var ReduxConfigurator
	 */
	protected $redux;

	/**
	 * @Inject
	 * @var Account
	 */
	protected $account;

	/**
	 * @Inject
	 * @var Notices
	 */
	public $notices;

	public function setUpHooks()
	{
		$loader = $this->hooksLoader;

		$loader->add_action('wp_ajax_travelpayouts_widget_render',
			WidgetPreviewController::getInstance(),
			'run'
		);
		/** @see Admin::localize_scripts() */
		$loader->add_action('admin_enqueue_scripts', $this, 'localize_scripts');
		/** @see Admin::importFile() */
		$loader->add_action('wp_ajax_travelpayouts_import_file', $this, 'importFile');
		/** @see Admin::migrate() */
		$loader->add_action('wp_ajax_travelpayouts_migrate', $this, 'migrate');
		/** @see Admin::migrateCancel() */
		$loader->add_action('wp_ajax_travelpayouts_migrate_cancel', $this, 'migrateCancel');
		/** @see Admin::clearPlatformsSelectCache() */
		$loader->add_action('wp_ajax_travelpayouts_clear_platforms_select_cache', $this, 'clearPlatformsSelectCache');
		/** @see Admin::migrateSearchForms() */
		$loader->add_action('wp_ajax_travelpayouts_migrate_search_forms', $this, 'migrateSearchForms');
		/** @see Admin::load_redux_options() */
		$loader->add_action('plugins_loaded', $this, 'load_redux_options');
		/** @see Admin::add_page() */
		$loader->add_action('admin_menu', $this->get_landing_page(), 'add_page');
		/** @see Admin::admin_notices() */
		$loader->add_action('admin_notices', $this, 'admin_notices');
		/** @see Admin::overrideReduxCss() */
		$loader->add_action('redux_travelpayouts/page/' . TRAVELPAYOUTS_REDUX_OPTION . '/enqueue', $this, 'overrideReduxCss');
		if (function_exists('wp_enqueue_editor')) {
			/** @see Admin::enqueue_block_editor_assets() */
			$loader->add_action('wp_enqueue_editor', $this, 'enqueue_block_editor_assets');
		} else {
			/** @see Admin::enqueue_block_editor_assets() */
			$loader->add_action('admin_enqueue_scripts', $this, 'enqueue_block_editor_assets');
		}
		/** @see Admin::landing_page_action() */

		$loader->add_action(
			'admin_action_' . LandingPage::ACTION,
			$this,
			'landing_page_action'
		);
		/** @see Admin::trackMarkerChanged() */

		$loader->add_action(
			'update_option_' . TRAVELPAYOUTS_REDUX_OPTION,
			$this,
			'trackMarkerChanged',
			10,
			2
		);
		/** @see Admin::pluginVersionAction() */
		$loader->add_action('init', $this, 'pluginVersionAction');
		/** @see Admin::trackVersionChanged() */
		$loader->add_action(
			'update_option_' . TRAVELPAYOUTS_VERSION_KEY,
			$this,
			'trackVersionChanged',
			10,
			2
		);

		/** @see Admin::add_shortcodes_editor_btn_script() */
		$loader->add_filter('mce_external_plugins', $this, 'add_shortcodes_editor_btn_script');
		/** @see Admin::add_shortcodes_editor_btn() */
		$loader->add_filter('mce_buttons', $this, 'add_shortcodes_editor_btn');
		/** @see Admin::load_gutenberg_block() */
		$loader->add_action('init', $this, 'load_gutenberg_block');
	}

	public function load_redux_options()
	{
		if (Travelpayouts::getInstance()->currentUserCan('manage_options')) {
			OptionsInit::getInstance();
		}
	}

	/**
	 * @param $old
	 * @param $new
	 */
	public function trackMarkerChanged($old, $new)
	{
		if (
			isset($old['account_api_marker'], $new['account_api_marker']) && $old['account_api_marker'] !== $new['account_api_marker']
		) {
			$this->snowTracker->trackStructEvent(
				Tracker::CATEGORY_INSTALL,
				Tracker::ACTION_ACTIVATED,
				null,
				null,
				null,
				[
					'marker_old' => $old['account_api_marker'],
					'marker' => $new['account_api_marker'],
				]
			);
		}
	}

	/**
	 * @param $old
	 * @param $new
	 */
	public function trackVersionChanged($old, $new)
	{
		if (version_compare($new, $old, '>')) {
			$this->snowTracker->trackStructEvent(
				Tracker::CATEGORY_INSTALL,
				Tracker::ACTION_UPDATED,
				null,
				null,
				null,
				[
					'plugin_version_previous' => $old,
					'marker' => $this->account->getMarker(),
				]
			);

			$this->importOnUpdate($old, $new);
		}
	}

	public function pluginVersionAction()
	{
		// Если есть версия прошлого плагина будет виден апдейт
		// TRAVELPAYOUTS_VERSION_KEY то же значение что и в прошлой версии
		$pluginOptionVersion = get_option(TRAVELPAYOUTS_VERSION_KEY);

		if (empty($pluginOptionVersion) || $pluginOptionVersion != TRAVELPAYOUTS_VERSION) {
			update_option(TRAVELPAYOUTS_VERSION_KEY, TRAVELPAYOUTS_VERSION);
		}
	}

	public function overrideReduxCss()
	{
		wp_dequeue_style('redux-admin-css');
	}

	public function enqueue_block_editor_assets()
	{
		try {
			$this->assets->getAssetByName('admin-gutenberg-modal')->setInFooter(true)->enqueueStyle()->enqueueScript();
		} catch (RuntimeException $e) {
			$this->rollbar->error($e->getMessage());
		}
	}

	/**
	 * Add <script> tag with JavaScript object
	 * @since    1.0.0
	 */
	public function localize_scripts()
	{
		wp_localize_script('jquery',
			$this->plugin_name . 'FrontApiSettings',
			[
				'nonce' => wp_create_nonce('wp_rest'),
				'endpoint' => esc_url(rest_url('/travelpayouts/front')),
				'locale' => LanguageHelper::dashboardLocale(),
				'settings_locale' => LanguageHelper::tableLocale(),
			]
		);

		wp_localize_script('jquery',
			$this->plugin_name . 'Data',
			[
				'context' => $this->snowPlowContext,
			]
		);
	}

	public function migrate()
	{
		/**
		 * import on plugin update
		 * add_action( 'upgrader_process_complete', function( $upgrader_object, $options ) {
		 *      import here
		 * }, 10, 2 );
		 */

		if (!Travelpayouts::getInstance()->currentUserCan('manage_options')) {
			die(Travelpayouts::__('Insufficient access rights!'));
		}

		$options = get_option(Migration::SOURCE_OPTION_NAME);
		$importDone = get_option(Migration::IMPORT_DONE_OPTION_NAME);

		if ($options && $importDone != Migration::IMPORT_DONE_TRUE) {
			$this->importModel()->import();
		}

		echo json_encode([
			'status' => 'success',
			'action' => 'reload',
		]);
		die ();
	}

	public function migrateCancel()
	{
		if (!Travelpayouts::getInstance()->currentUserCan('manage_options')) {
			die(Travelpayouts::__('Insufficient access rights!'));
		}

		update_option(Migration::IMPORT_DONE_OPTION_NAME, Migration::IMPORT_DONE_TRUE);

		echo json_encode([
			'status' => 'success',
			'action' => 'reload',
		]);
		die ();
	}

	public function clearPlatformsSelectCache()
	{
		if (!Travelpayouts::getInstance()->currentUserCan('manage_options')) {
			die(Travelpayouts::__('Insufficient access rights!'));
		}

		Platforms::getInstance()->clearCache();

		echo json_encode([
			'status' => 'success',
			'action' => 'reload',
		]);
		die ();
	}

	public function migrateSearchForms()
	{
		if (!Travelpayouts::getInstance()->currentUserCan('manage_options')) {
			die(Travelpayouts::__('Insufficient access rights!'));
		}
		$this->importModel()->importSearchForms();

		echo json_encode([
			'status' => 'success',
			'action' => 'reload',
		]);
		die ();
	}

	public function importFile()
	{
		if (!Travelpayouts::getInstance()->currentUserCan('manage_options')) {
			die(Travelpayouts::__('Insufficient access rights!'));
		}

		if (isset($_POST['settings']) && !empty($_POST['settings'])) {
			try {
				$this->importModel($_POST['settings'])->import();
			} catch (Exception $exception) {
				$this->notices->add(
					Notice::create('redux-import-notice')
						->setType(Notice::NOTICE_TYPE_ERROR)
						->setTitle(Travelpayouts::__('Import failed'))
				);
				die ();
			}
		}

		$this->notices->add(
			Notice::create('redux-import-notice')
				->setType(Notice::NOTICE_TYPE_SUCCESS)
				->setTitle(Travelpayouts::__('Import completed'))
		);

		echo json_encode([
			'status' => 'success',
			'action' => 'reload',
		]);
		die ();
	}

	/**
	 * @param $old
	 * @param $new
	 */
	public function importOnUpdate($old, $new)
	{
		if (version_compare($old, '0.7.13', '<=')) {
			$importModel = $this->importModel();
			// Импортирует все настройки после перехода с 0.7.13
			$importModel->importSettings();
			// импортируем поисковые формы, если поисковая форма есть, пропускаем
			$importModel->importSearchForms();
		}
	}

	public function get_landing_page()
	{
		return new Menu(
			new LandingPage($this),
			LandingModel::LANDING_SLUG,
			Travelpayouts::__('Travelpayouts WordPress plugin'),
			Travelpayouts::_x('Travelpayouts', 'Travelpayouts')
		);
	}

	public function admin_notices()
	{
		if (!Travelpayouts::getInstance()->currentUserCan('manage_options')) {
			return false;
		}

		// Добавляет welcome (плашку) уведомление
		$this->welcomeNotice();
		$this->importNotice();
		$this->platformNotice();

		// Получает и отображает уведомления
		$this->notices->render();
	}

	public function landing_page_action()
	{
		if (!Travelpayouts::getInstance()->currentUserCan('manage_options')) {
			die(Travelpayouts::__('Insufficient access rights!'));
		}

		if (wp_verify_nonce($_POST['_wpnonce'], LandingPage::ACTION)) {
			$model = new LandingModel();
			$model->setSanitizedAttributes($_POST);
			$model->save();

			exit(wp_redirect($_POST['_wp_http_referer']));
		}

		die(Travelpayouts::__('WP nonce verification failed!'));
	}

	/**
	 * Добавляет уведомление если redux plugin не активирован
	 * пустое значения API token или affiliate marker в настройках аккаунта
	 * @return bool
	 */
	private function welcomeNotice()
	{
		if (function_exists('get_current_screen')) {
			$page = get_current_screen();

			// не отображать на страницах landing, активация плагина
			$pages = [
				'plugins_page_install-required-plugins',
				'settings_page_' . LandingModel::LANDING_SLUG,
			];
			if (in_array($page->base, $pages)) {
				return true;
			}
		}

		if (empty($this->account->getToken()) || empty($this->account->getMarker())) {
			$this->notices->add(
				Notice::create('is-active-redux-notice')
					->setTitle(Travelpayouts::__('Activate the Travelpayouts plugin'))
					->setDescription(Travelpayouts::__('Enter your Travelpayouts authorization details and start earning now'))
					->addButton(
						NoticeButton::create(Travelpayouts::__('Activate the plugin'))
							->setType(NoticeButton::BUTTON_TYPE_PRIMARY)
							->setUrl(wp_nonce_url(add_query_arg(['page' => LandingModel::LANDING_SLUG], admin_url('options-general.php'))))
					)
			);
		}
		return true;
	}

	private function importNotice()
	{
		$this->assets->loader->registerAsset('admin-notice');
		$sourceOption = get_option(Migration::SOURCE_OPTION_NAME);
		$canImport = get_option(Migration::IMPORT_DONE_OPTION_NAME) != Migration::IMPORT_DONE_TRUE;

		if ($sourceOption && $canImport) {
			$this->notices->add(
				Notice::create('redux-import-action-notice')
					->setTitle(Travelpayouts::__('Import settings from the previous version'))
					->setDescription(Travelpayouts::__('You updated the Travelpayotus WordPress plugin. This is a new version and has differences with your previous one. To be sure that your existing settings were imported correctly, you have to confirm and click the button on the right. Please double-check after importing.'))
					->addButton(
						NoticeButton::create(Travelpayouts::__(Travelpayouts::__('Skip import')))
							->setType(NoticeButton::BUTTON_TYPE_SECONDARY)
							->setClassName('travelpayouts-migrate-cancel')
					)
					->addButton(
						NoticeButton::create(Travelpayouts::__('Import settings'))
							->setType(NoticeButton::BUTTON_TYPE_PRIMARY)
							->setClassName('travelpayouts-migrate')
					)
					->setCloseable()
			);
		}
	}

	private function platformNotice()
	{
		$platforms = Platforms::getInstance();

		if ($platforms->showSelectPlatformNotice()) {
			$this->notices->add(
				Notice::create('account-platform-selected-notice')
					->setTitle(Travelpayouts::__('Action is required!'))
					->setDescription(Travelpayouts::__('Choose a traffic source<br>To correctly track your stats for your website, please select a traffic source it belongs to in the settings'))
					->addButton(
						NoticeButton::create(Travelpayouts::__('Account settings'))
							->setType(NoticeButton::BUTTON_TYPE_PRIMARY)
							->setClassName('travelpayouts-open-settings-tab')
							->setUrl(add_query_arg([
								'page' => 'travelpayouts_options',
								'tab' => 10,
							], admin_url('admin.php')))
							->setAttributes(['data-tab' => 10])
					)
					->setCloseable()
			);
		}

		if (!$platforms->isActiveRequiredPrograms()) {
			$this->notices->add(
				Notice::create('account-program-required-notice')
					->setTitle(Travelpayouts::__('Action is required!'))
					->setDescription(Travelpayouts::__('Please add required programs for selected platform'))
					->addButton(
						NoticeButton::create(Travelpayouts::__('Activate programs'))
							->setType(NoticeButton::BUTTON_TYPE_PRIMARY)
							->setUrl('https://www.travelpayouts.com/programs')
							->openInNewWindow()
					)
			);
		}
	}

	/**
	 * @param $buttons
	 * @return array
	 */
	public function add_shortcodes_editor_btn($buttons)
	{
		$buttons = array_merge($buttons, [$this->plugin_name . '_shortcodes_btn']);

		return $buttons;
	}

	public function add_shortcodes_editor_btn_script($pluginList)
	{
		$classicEditorPluginName = $this->plugin_name . '_shortcodes_editor_btn';

		$classicEditorAssetList = Travelpayouts::getInstance()
			->assets
			->getAssetByName('admin-classic-editor-injector')->getJavascript();

		if ($classicEditorAsset = ArrayHelper::getFirst($classicEditorAssetList)) {
			$pluginList[$classicEditorPluginName] = $classicEditorAsset;
		}

		return $pluginList;
	}

	public function load_gutenberg_block()
	{
		try {
			$gutenbergAsset = Travelpayouts::getInstance()
				->assets
				->getAssetByName('admin-gutenberg-injector')
				->registerStyle(['wp-editor'], null)
				->registerScript([
					'wp-blocks',
					'wp-i18n',
					'wp-element',
					'wp-editor',
				],
					true
				)->localizeScript(
					$this->plugin_name . '_block_shortcodes_globals', // Array containing dynamic data for a JS Global.
					[
						'pluginDirPath' => plugin_dir_path(__DIR__),
						'pluginDirUrl' => plugin_dir_url(__DIR__),
					]
				);
			/**
			 * Register Gutenberg block on server-side.
			 * Register the block on server-side to ensure that the block
			 * scripts and styles for both frontend and backend are
			 * enqueued when the editor loads.
			 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
			 * @since 1.16.0
			 */
			if (function_exists('register_block_type')) {
				register_block_type(
					$this->plugin_name . '/shortcodes', [
						'editor_style' => $gutenbergAsset->styleHandlerName,
						'editor_script' => $gutenbergAsset->scriptHandlerName,
					]
				);
			}
		} catch (RuntimeException $e) {
			$this->rollbar->error($e->getMessage());
		}
	}

	/**
	 * @param null $source
	 * @return Migration
	 */
	protected function importModel($source = null)
	{
		if ($source === null) {
			$source = get_option(Migration::SOURCE_OPTION_NAME);
		}

		return new Migration([
			'redux' => $this->redux,
			'source' => $source,
		]);
	}
}
