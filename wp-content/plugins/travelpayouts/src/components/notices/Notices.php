<?php

namespace Travelpayouts\components\notices;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\Vendor\League\Plates\Engine;
use Travelpayouts\components\BaseInjectedObject;

/**
 * Class Notices
 * @package Travelpayouts\src\components
 */
class Notices extends BaseInjectedObject
{
	/**
	 * @Inject
	 * @var Engine
	 */
	protected $template;

	protected $cookiePrefix = 'tp-notice-';

	/**
	 * @return mixed|void
	 */
	protected function getNotices()
	{
		return get_option($this->optionName(), []);
	}

	/**
	 * Отображает уведомления и очищает их сразу после отображения
	 */
	public function render()
	{
		$notices = $this->getNotices();
		foreach ($notices as $key => $notice) {
			$cookieKey = $this->cookiePrefix . $key;
			if (!isset($_COOKIE[$cookieKey])) {
				echo $notice;
			}
		}

		if (!empty($notices)) {
			$this->clearAll();
		}
	}

	/**
	 * @param $key
	 * @return bool
	 */
	public function clearByKey($key)
	{
		$notices = $this->getNotices();
		unset($notices[$key]);

		return $this->updateOption($notices);
	}

	/**
	 * @return bool
	 */
	protected function clearAll()
	{
		return $this->updateOption([]);
	}

	/**
	 * @param $data
	 * @return bool
	 */
	protected function updateOption($data)
	{
		return update_option($this->optionName(), $data);
	}

	/**
	 * @return string
	 */
	protected function optionName()
	{
		return TRAVELPAYOUTS_PLUGIN_NAME . '_notices';
	}

	public function add(Notice $notice)
	{
		$renderedNotice = $this->template->render('admin::notices/default', $notice->getResult());
		$this->updateOption(array_merge($this->getNotices(), [$notice->name => $renderedNotice]));
	}
}
