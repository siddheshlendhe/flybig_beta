<?php

/**
 * The public-facing functionality of the plugin.
 * @link       http://www.travelpayouts.com/?locale=en
 * @since      1.0.0
 * @package    Travelpayouts
 * @subpackage Travelpayouts/public
 */

namespace Travelpayouts\frontend;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\BaseInjectedObject;
use Travelpayouts\modules\settings\Settings;

/**
 * The public-facing functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * @package    Travelpayouts
 * @subpackage Travelpayouts/public
 * @author     travelpayouts < wpplugin@travelpayouts.com>
 */
class Frontend extends BaseInjectedObject
{
	/**
	 * The ID of this plugin.
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 * @Inject("name")
	 */
	private $plugin_name;

	/**
	 * @var Settings
	 * @Inject
	 */
	protected $settings;

	public function setUpHooks()
	{
		$loader = Travelpayouts::getInstance()->hooksLoader;
		/** @see Frontend::enqueue_scripts() */
		$loader->add_action('wp_enqueue_scripts', $this, 'enqueue_scripts', 100);
		/** @see Frontend::external_link_redirect() */
		$loader->add_filter('template_redirect', $this, 'external_link_redirect');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		/**
		 * TODO проверить если jquery не registered или wp_deregister_script или подменен другим
		 */
		if (wp_script_is('jquery', 'registered')) {
			wp_enqueue_script('jquery');
			wp_add_inline_script('jquery', $this->action_travelpayouts_load_table_events());
		}
	}

	private function action_travelpayouts_load_table_events()
	{
		$settings = $this->settings;
		$btn_onclick_event = $onload_event = 'return true;';
		if (isset($settings->section->data)) {
			$btn_onclick_event = $settings->section->data->get('table_btn_event');
			$onload_event = $settings->section->data->get('table_load_event');
		}

		$functions = 'function ' . $this->plugin_name . 'OnTableBtnClickEvent() {' . $btn_onclick_event . '} ';
		$functions .= 'function ' . $this->plugin_name . 'OnTableLoadEvent() {' . $onload_event . '} ';

		return $functions;
	}

	/**
	 * Redirect domain/travelpayouts_redirect?https://google.com
	 */
	public function external_link_redirect()
	{
		if (preg_match('/' . TRAVELPAYOUTS_TEXT_DOMAIN . '_redirect\/?\?/', $_SERVER['REQUEST_URI'])) {
			header('Location: ' . $_SERVER['QUERY_STRING'], true, 302);
			exit;
		}
	}
}
