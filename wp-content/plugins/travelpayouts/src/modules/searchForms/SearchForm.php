<?php

namespace Travelpayouts\modules\searchForms;

use Travelpayouts;
use Travelpayouts\admin\redux\base\ModuleSection;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\components\HtmlHelper;
use Travelpayouts\includes\migrations\TablesMigration;

class SearchForm extends ModuleSection
{
	/**
	 * @inheritdoc
	 */
	public function section()
	{
		return [
			'title' => Travelpayouts::__('Search forms'),
			'icon' => 'el el-search',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		global $wpdb;

		$dbTables = new TablesMigration(['db' => $wpdb]);
		$searchForms = $dbTables->getSearchForms();
		$importButton = [];

		if (!empty($searchForms)) {
			$importButton = [
				'id' => 'reimport_search_forms',
				'type' => 'travelpayouts_reimport_search_forms',
			];
		}
		$fieldId = 'search_forms_data';

		return [
			ReduxFields::raw('search_forms_component', HtmlHelper::tagArrayContent('div', [
				'style'=> 'margin: -15px -10px;'
			], HtmlHelper::reactWidget('TravelpayoutsSearchForms', [
				'outputSelector' => "#{$this->getId()}_{$fieldId}",
				'apiUrl'=> admin_url( 'admin-ajax.php' ),
			]))),
			[
				'id' => $fieldId,
				'type' => 'textarea',
				'readonly' => 'true',
				'class' => 'hidden',
			],

			$importButton,
		];
	}

	/**
	 * @inheritDoc
	 */
	public function optionPath()
	{
		return 'search_forms';
	}
}
