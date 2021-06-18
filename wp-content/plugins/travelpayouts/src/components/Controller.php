<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components;

use Exception;
use Travelpayouts\traits\SingletonTrait;

abstract class Controller extends BaseInjectedObject
{
	use SingletonTrait;

	protected function getInputData()
	{
		try {
			$jsonData = file_get_contents('php://input');
			return json_decode($jsonData, true);
		} catch (Exception $e) {
			return null;
		}
	}

	/**
	 * @param string $name
	 * @param mixed $defaultValue
	 * @return mixed
	 */
	public function getInputParam($name, $defaultValue = null)
	{
		$inputData = $this->getInputData();
		if ($inputData) {
			if ($name) {
				return isset($inputData[$name])
					? $inputData[$name]
					: $defaultValue;
			}
			return $inputData;
		}
		return $defaultValue;
	}

	/***
	 * @param bool $success
	 * @param array $content
	 * @param array $meta
	 * @param bool $return
	 * @return false|string|void
	 */
	public function response($success, $content = [], $meta = [], $return = false)
	{
		$output = [
			'success' => $success,
			'data' => $content,
			'meta'=> $meta,
		];
		if ($return) {
			return wp_json_encode($output);
		}

		wp_send_json($output);
	}
}
