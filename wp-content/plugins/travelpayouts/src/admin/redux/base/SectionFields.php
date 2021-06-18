<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\admin\redux\base;
use Travelpayouts\Vendor\Adbar\Dot;

/**
 * Class SectionFields
 * @package Travelpayouts\admin\redux\base
 * @property-read array|null $fields
 */
abstract class SectionFields extends Base
{
    /**
     * @var Dot
     */
    private $_data;

    /**
     * Помечаем $parent как обязательный для наследников текущего класса
     * @param $parent
     * @param array $config
     */
    public function __construct($parent, $config = [])
    {
        parent::__construct($parent, $config);
    }

    /**
     * Добавляем необходимые префиксы к полям и возвращаем
     * @return array|null
     */
    public function getFields()
    {
        if (static::isActive()) {
            $fields = $this->fields();
            return $fields && is_array($fields) ? Helper::addPrefixToFields($fields, $this->optionPath) : null;
        }
        return null;
    }

    /**
     * Получаем данные из секции
     * @return Dot
     */
    public function getData()
    {
        if (!$this->_data) {
            $this->_data = new Dot($this->getOptionPathData());
        }
        return $this->_data;
    }

    public function setChildren($value)
    {
        throw new \RuntimeException('Method not implemented');
    }

    /**
     * @param string $fieldName
     * @return string
     */
    public function createFieldId($fieldName)
    {
        return $this->optionPath . '_' . $fieldName;
    }
}
