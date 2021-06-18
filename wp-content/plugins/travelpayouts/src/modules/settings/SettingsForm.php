<?php

namespace Travelpayouts\modules\settings;

use Travelpayouts;
use Travelpayouts\admin\redux\base\ModuleSection;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\dictionary\TravelpayoutsApiData;
use Travelpayouts\components\HtmlHelper;
use Travelpayouts\components\tables\enrichment\CaseHelper;
use Travelpayouts\components\Translator;
use Travelpayouts\components\Moment;

/**
 * Class SettingsForm
 * @package Travelpayouts\src\modules\settings
 */
class SettingsForm extends ModuleSection
{
    /**
     * @Inject
     * @var Moment
     */
    protected $moment;

	public $date_format;
	public $distance_units;
	public $selectMultiLang;
	public $hotels_source;
	public $language;
	public $origin_case;
	public $destination_case;
	public $currency;
	public $currency_symbol_display;
	public $flights_after_url;
	public $hotels_after_url;
	public $editor_buttons;
	public $script_location;
	public $airline_logo_dimensions;
	public $redirect;
	public $target_url;
	public $nofollow;
	public $table_btn_event;
	public $table_load_event;

	/**
	 * @inheritdoc
	 */
	public function section()
	{
		return [
			'title' => Travelpayouts::__('Settings'),
			'icon' => 'el el-cog',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		return array_merge(
			[
				ReduxFields::radio(
					'date_format_radio',
					Travelpayouts::__('Date format'),
					[
						'j F Y' => $this->moment->format('j F Y') . ' ' . ReduxFields::pre('j F Y'),
						'F j, Y' => $this->moment->format('F j, Y') . ' ' . ReduxFields::pre('F j, Y'),
						'j M Y' => $this->moment->format('j M Y') . ' ' . ReduxFields::pre('j M Y'),
						'j F' => $this->moment->format('j F') . ' ' . ReduxFields::pre('j F'),
						'd-m-y' => $this->moment->format('d-m-y') . ' ' . ReduxFields::pre('d-m-y'),
						'custom' => Travelpayouts::__('Custom'),
					],
					'j F Y'
				),
				ReduxFields::text(
					'date_format',
					Travelpayouts::__('Custom date format'),
					'',
					$this->dateFormatDescription(),
					'd.m.Y',
					[
						ReduxFields::get_ID($this->optionPath, 'date_format_radio'),
						'equals',
						'custom',
					]
				),
				ReduxFields::select(
					'distance_units',
					Travelpayouts::__('Distance units'),
					ReduxOptions::distance_units(),
					'km'
				),
			],
			ReduxFields::selectMultiLang(
				'flights_source',
				Travelpayouts::__('Host (Flights)'),
				ReduxOptions::flight_sources(),
				ReduxOptions::FLIGHTS_SOURCE_AVIASALES_RU
			),
			ReduxFields::selectMultiLang(
				'hotels_source',
				Travelpayouts::__('Host (Hotels)'),
				ReduxOptions::hotel_sources(),
				'ru-RU'
			),
			[
				ReduxFields::select(
					'language',
					Travelpayouts::__('Tables and widgets language'),
					Travelpayouts::getInstance()->translator->getSupportedLocales(),
					ReduxOptions::get_default_table_language()
				),
				ReduxFields::selectRequired(
					'origin_case',
					Travelpayouts::__('Origin case'),
					CaseHelper::getCasesList(),
					'settings_language',
					Translator::RUSSIAN,
					TravelpayoutsApiData::CASE_GENITIVE
				),
				ReduxFields::selectRequired(
					'destination_case',
					Travelpayouts::__('Destination case'),
					CaseHelper::getCasesList(),
					'settings_language',
					Translator::RUSSIAN,
					TravelpayoutsApiData::CASE_ACCUSATIVE
				),
				ReduxFields::select(
					'currency',
					Travelpayouts::__('Currency'),
					ReduxOptions::table_widget_currencies(),
					ReduxOptions::getDefaultCurrencyCode()
				),
				ReduxFields::select(
					'currency_symbol_display',
					Travelpayouts::__('Show the currency'),
					ReduxOptions::currency_code_position(),
					'after'
				),
				ReduxFields::select(
					'flights_after_url',
					Travelpayouts::__('Action after click (Flights)'),
					ReduxOptions::actions_after_click_flights(),
					'results'
				),
				ReduxFields::select(
					'hotels_after_url',
					Travelpayouts::__('Action after click (Hotels)'),
					ReduxOptions::actions_after_click_hotels(),
					'hotel'
				),
				ReduxFields::select(
					'editor_buttons',
					Travelpayouts::__('Buttons in the editor'),
					ReduxOptions::editor_buttons(),
					'compact'
				),
				ReduxFields::select(
					'script_location',
					Travelpayouts::__('Script include'),
					ReduxOptions::script_locations(),
					'in_footer'
				),
				ReduxFields::dimensionsValidationLogo(
					'airline_logo_dimensions',
					Travelpayouts::__('Airlines logo size'),
					100,
					35,
					Travelpayouts::__('Enter width value under 300 and height under 200')
				),
				ReduxFields::checkbox(
					'redirect',
					Travelpayouts::__('Redirect'),
					Travelpayouts::__(
						'In this case, the 301 Redirect, which is more preferable for search engines, 
                    will be activated. We recommend that you don’t change this option.'
					),
					true
				),
				ReduxFields::checkbox(
					'target_url',
					Travelpayouts::__('Open in a new window'),
					'',
					true
				),
				ReduxFields::checkbox(
					'nofollow',
					Travelpayouts::__('Add the nofollow attribute'),
					Travelpayouts::__('This attribute avoids getting undesirable search results into the 
                search engines index. We recommend that you don’t change this option.'),
					true
				),
				ReduxFields::checkbox(
					ReduxOptions::getFileCacheOption(),
					Travelpayouts::__('Use FileCache'),
					Travelpayouts::__('Select this option to start using FileCache'),
					false
				),
				ReduxFields::simple_text_slider(
					ReduxOptions::cache_time_key_flights(),
					Travelpayouts::__('Cache timeout flights (hours)'),
					'3',
					'3',
					'48'
				),
				ReduxFields::simple_text_slider(
					ReduxOptions::cache_time_key_hotels(),
					Travelpayouts::__('Cache timeout hotels (hours)'),
					'24',
					'24',
					'72'
				),
				ReduxFields::text(
					'table_btn_event',
					Travelpayouts::__('Event tracking. "Find" button'),
					'',
					$this->eventsDescription()
				),
				ReduxFields::text(
					'table_load_event',
					Travelpayouts::__('Event tracking. Table is loaded'),
					'',
					$this->eventsDescription()
				),
				[
					'id' => 'settings_import',
					'type' => 'travelpayouts_settings_import',
					'title' => Travelpayouts::__('Import settings from v1'),
					'subtitle' => Travelpayouts::__('Load import settings from Travelpayouts WP Plugin (version up to v. 1) and press import'),
				],
			]
		);
	}

	protected function eventsDescription()
	{
		return implode('', [
			Travelpayouts::__('Set a goal in Yandex Metrika or Google Analytics and paste the code in this field to track the event (reaching the goal)'),
			HtmlHelper::tagArrayContent('div', ['class' => 'modifiers--m-top'], [
				HtmlHelper::tagArrayContent('div', ['class' => 'typography--bold'], [
					Travelpayouts::__('For example'),
					':',
				]),
				HtmlHelper::tagArrayContent('div', ['class' => 'layouts-row--horizontal modifiers--m-top modifiers--m-bottom'], [
					HtmlHelper::tag('div', ['class' => 'modifiers--m-right--big  modifiers--round typography--pre'], "yaCounterXXXXXX.reachGoal('TARGET_NAME');"),
					HtmlHelper::tag('div', ['class' => ''], 'or'),
					HtmlHelper::tag('div', ['class' => 'modifiers--m-left--big modifiers--round typography--pre'], "ga('send', 'event', 'category', 'action');"),
				]),
			]),
			HtmlHelper::tagArrayContent('div', ['class' => 'modifiers--m-top--big'], [
				HtmlHelper::tagArrayContent('div', ['class' => 'typography--bold'], [
					Travelpayouts::__('You can also combine multiple events'),
					':',
				]),
				HtmlHelper::tagArrayContent('div', ['class' => 'layouts-row--horizontal modifiers--m-top'], [
					HtmlHelper::tag('div', ['class' => 'modifiers--round typography--pre'], "yaCounterXXXXXX.reachGoal('TARGET_NAME'); ga('send', 'event', 'category', 'action');"),
				]),
			]),
		]);
	}

	protected function dateFormatDescription()
	{
		return HtmlHelper::tagArrayContent('div', ['class' => 'modifiers--m-top--big'], [
			Travelpayouts::__('If you want to set a custom date format properly you can check the characters and corresponding formats below'),

			HtmlHelper::tag('div', ['class' => 'typography--bold'], Travelpayouts::__('Day')),
			HtmlHelper::tag('div', ['class' => 'modifiers--m-top--big'], ReduxFields::pre('j') . ' ' . Travelpayouts::__('Day of the month without leading zeros')),
			HtmlHelper::tag('div', ['class' => 'modifiers--m-top--big'], ReduxFields::pre('d') . ' ' . Travelpayouts::__('Day of the month, 2 digits with leading zeros')),

			HtmlHelper::tag('div', ['class' => 'typography--bold modifiers--m-top--big'], Travelpayouts::__('Month')),
			HtmlHelper::tag('div', ['class' => 'modifiers--m-top--big'], ReduxFields::pre('F') . ' ' . Travelpayouts::__('A full textual representation of a month, such as January or March')),
			HtmlHelper::tag('div', ['class' => 'modifiers--m-top--big'], ReduxFields::pre('m') . ' ' . Travelpayouts::__('Numeric representation of a month, with leading zeros')),
			HtmlHelper::tag('div', ['class' => 'modifiers--m-top--big'], ReduxFields::pre('M') . ' ' . Travelpayouts::__('A short textual representation of a month, three letters')),
			HtmlHelper::tag('div', ['class' => 'modifiers--m-top--big'], ReduxFields::pre('n') . ' ' . Travelpayouts::__('Numeric representation of a month, without leading zeros')),

			HtmlHelper::tag('div', ['class' => 'typography--bold modifiers--m-top--big'], Travelpayouts::__('Month')),
			HtmlHelper::tag('div', ['class' => 'modifiers--m-top--big'], ReduxFields::pre('Y') . ' ' . Travelpayouts::__('A full numeric representation of a year, 4 digits')),
			HtmlHelper::tag('div', ['class' => 'modifiers--m-top--big'], ReduxFields::pre('y') . ' ' . Travelpayouts::__('A two-digit representation of a year')),
		]);
	}

	/**
	 * @inheritDoc
	 */
	public function optionPath()
	{
		return 'settings';
	}
}
