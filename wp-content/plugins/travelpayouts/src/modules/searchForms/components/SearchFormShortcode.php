<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\searchForms\components;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\HtmlHelper as Html;
use Travelpayouts\components\Model;
use Travelpayouts\components\shortcodes\ShortcodeModel;
use Travelpayouts\modules\account\Account;
use Travelpayouts\modules\searchForms\components\models\SearchForm;
use Travelpayouts\modules\searchForms\components\models\WidgetCode;
use Travelpayouts\modules\searchForms\components\models\widgetCode\Direction;
use Travelpayouts\modules\searchForms\components\models\widgetCode\HotelCity;

/**
 * Class SearchShortcodes
 * @package Travelpayouts\src\modules\searchForms\components
 * @property HotelCity|null $hotel_city
 * @property Direction|null $origin
 * @property Direction|null $destination
 * @property-read SearchForm|null $model
 * @property-read string|null $marker
 * @property-read WidgetCode|null $widgetCode
 */
class SearchFormShortcode extends ShortcodeModel
{
	const TYPE_AVIA = 'avia';
	const TYPE_HOTEL = 'hotel';
	const TYPE_AVIA_HOTEL = 'avia_hotel';
	/**
	 * @var string
	 */
	public $id;
	/**
	 * @var string
	 */
	public $slug;
	/**
	 * @var string
	 */
	public $subid;
	/**
	 * @var bool
	 */
	public $applyParamsFromCode;

	/**
	 * @var HotelCity|null
	 */
	protected $_hotel_city;
	/**
	 * @var string|null
	 */
	protected $_marker;

	/**
	 * @var Direction|null
	 */
	protected $_origin;
	/**
	 * @var Direction|null
	 */
	protected $_destination;
	/**
	 * @return Direction|null
	 * /**
	 * @Inject
	 * @var Account
	 */
	protected $accountModule;
	/**
	 * @var SearchForm|null
	 */
	protected $_model;

	public function rules()
	{
		return [
			[
				['id'],
				'idOrSlugValidator',
				'params' => [
					'attributeList' => [
						'id',
						'slug',
					],
				],
				'skipOnEmpty' => false,
			],
			[
				[
					'slug',
					'subid',
					'applyparamsfromcode',
				],
				'string',
			],
			[
				[
					'model',
					'origin',
					'destination',
					'hotel_city',
					'widgetCode',
				],
				'modelValidator',
			],
		];
	}

	public function idOrSlugValidator($attribute, $params)
	{
		if (isset($params['attributeList'])) {
			$hasValidAttributes = array_map(function ($key) {
				return (bool)$this->$key;
			}, $params['attributeList']);

			$isValid = in_array(true, $hasValidAttributes, true);

			if (!$isValid) {
				$attributesAsString = implode(', ', $params['attributeList']);
				$this->add_error($attribute, Travelpayouts::__('One of parameters ({attributes}) is required', [
					'attributes' => $attributesAsString,
				]));
			}
		}
	}

	/**
	 * @return HotelCity|null
	 */
	public function getHotel_city()
	{
		return $this->_hotel_city;
	}

	public function setHotel_city($value)
	{
		if (is_string($value)) {
			$this->_hotel_city = HotelCity::createFromString($value);
		}
	}

	/**
	 * @return SearchForm|null
	 */
	public function getModel()
	{
		if (!$this->_model && ($this->id || $this->slug)) {
			$this->_model = $this->id ?
				SearchForm::getInstance()->findByPk($this->id) :
				SearchForm::getInstance()->findByColumnValue('slug', $this->slug);
		}
		return $this->_model;
	}

	public function render()
	{
		return $this->validate() ? $this->mergeAttributesWithWidgetCode()->renderWidget() : '';
	}

	public function before_validate()
	{
		/**
		 * если аттрибут applyParamsFromCode представлен, то перезаписываем параметр в модели
		 */
		if ($this->applyParamsFromCode !== null) {
			$this->model->applyParams = $this->applyParamsFromCode;
		}
		return parent::before_validate();
	}

	protected function mergeAttributesWithWidgetCode()
	{

		$widgetCode = $this->widgetCode;
		switch ($this->model->type) {
			case self::TYPE_AVIA:
				$widgetCode->hotel = null;
				break;
			case self::TYPE_HOTEL:
				$widgetCode->origin = null;
				$widgetCode->destination = null;
				break;
		}

		if ($this->hotel_city) {
			$widgetCode->hotel = $this->hotel_city;
		}

		if ($this->origin) {
			$widgetCode->origin = $this->origin;
		}

		if ($this->destination) {
			$widgetCode->destination = $this->destination;
		}
		if ($marker = $this->marker) {
			$widgetCode->marker = $marker;
			if ($widgetCode->best_offer) {
				$widgetCode->best_offer->marker = $marker;
			}
		}
		return $this;
	}

	public function getMarker()
	{
		if (!$this->_marker) {

			$subIdParams = array_filter([
				$this->accountModule->marker,
				$this->subid,
			]);

			$this->_marker = implode('.', $subIdParams);
		}
		return $this->_marker;
	}

	protected function renderWidget()
	{
		if ($this->widgetCode) {
			$widgetId = $this->model->widgetId;
			$widgetParams = json_encode($this->widgetCode->toArray());
			$scriptParams = <<<JS
window.TP_FORM_SETTINGS = window.TP_FORM_SETTINGS || {};
window.TP_FORM_SETTINGS["$widgetId"] = $widgetParams;
JS;
			return implode('', [
				Html::script($scriptParams),
				Html::scriptFile($this->model->url, ['async' => 'async']),
			]);
		}
		return '';
	}

	/**
	 * @inheritDoc
	 */
	public static function shortcodeTags()
	{
		return ['tp_search_shortcodes'];
	}

	/**
	 * @inheritDoc
	 */
	public static function render_shortcode_static($attributes = [], $content = null, $tag = '')
	{
		$model = new self();
		$model->attributes = $attributes;
		return $model->render();
	}

	/**
	 * @param $value
	 */
	public function setOrigin($value)
	{
		if (is_string($value)) {
			$this->_origin = new Direction(['iata' => $value]);
		}
	}

	/**
	 * @return Direction|null
	 */
	public function getOrigin()
	{
		return $this->_origin;
	}

	/**
	 * @param $value
	 */
	public function setDestination($value)
	{
		if (is_string($value)) {
			$this->_destination = new Direction(['iata' => $value]);
		}
	}

	/**
	 * @return Direction|null
	 */
	public function getDestination()
	{
		return $this->_destination;
	}

	public function modelValidator($attribute)
	{
		/** @var Model|null $model */
		$model = $this->$attribute;
		if ($model) {
			$model->validate();
			foreach ($model->getErrors() as $modelAttribute => $errorList) {
				foreach ($errorList as $error) {
					$this->add_error($attribute, $error);
				}
			}
		}
	}

	/**
	 * @return WidgetCode|null
	 */
	public function getWidgetCode()
	{
		return $this->model->widgetCode;
	}

	public function setApplyparamsfromcode($value)
	{
		$this->applyParamsFromCode = filter_var($value, FILTER_VALIDATE_BOOLEAN);
	}
}
