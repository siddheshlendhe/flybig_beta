<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\searchForms;
use Travelpayouts\Vendor\Adbar\Dot;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\module\ModuleRedux;
use Travelpayouts\includes\Router;
use Travelpayouts\modules\searchForms\components\Controller;

/**
 * Class Search
 * @package Travelpayouts\src\modules\searchForms
 * @property-read SearchForm $section
 * @property-read Dot $data
 */
class Search extends ModuleRedux
{
	/**
	 * @Inject
	 * @var SearchForm
	 */
	public $section;

	/**
	 * @Inject
	 * @var Router
	 */
	protected $router;
	/**
	 * @Inject
	 * @var Controller
	 */
	protected $controller;
	/**
	 * @inheritdoc
	 */
	protected $shortcodeList = [
		components\SearchFormShortcode::class,
	];


	public function init()
	{
		$this->setUpRoutes();
	}

	protected function setUpRoutes()
	{
		$controller = $this->controller;
		$this->router->addRoutes([
			['GET', 'searchForms/raw-data', [$controller, 'actionRawData']],
			['GET', 'searchForms', [$controller, 'actionIndex']],
			['GET', 'searchForms/index', [$controller, 'actionIndex']],
			['POST', 'searchForms/create', [$controller, 'actionCreate']],
			['GET', 'searchForms/view/{id:\d+}', [$controller, 'actionView']],
			['GET', 'searchForms/slug/{slug:\w+}', [$controller, 'actionViewBySlug']],
			['PUT', 'searchForms/update/{id:\d+}', [$controller, 'actionUpdate']],
			['PUT', 'searchForms/delete', [$controller, 'actionDeleteById']],
			['DELETE', 'searchForms/delete/{id:\d+}', [$controller, 'actionDelete']],
			['GET', 'searchForms/translations', [$controller, 'actionGetTranslations']],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function registerSection()
	{
		$this->section->register();
	}

	/**
	 * @return Dot
	 */
	public function getData()
	{
		return $this->section->data;
	}
}
