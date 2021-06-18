<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components;

abstract class BaseInjectedObject extends BaseObject
{
	public function __construct($config = [])
	{
		Container::getInstance()->inject($this);
		parent::__construct($config);
	}
}
