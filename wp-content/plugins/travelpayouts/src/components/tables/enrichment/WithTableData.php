<?php

namespace Travelpayouts\components\tables\enrichment;
use Travelpayouts\Vendor\Adbar\Dot;
use Travelpayouts\components\tables\TableDataModel;

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 * Стандартный набор геттеров/сеттеров для классов, в которых подключен table_data
 * @property-read null|TableDataModel $table_data
 * @property-read Dot $redux_module_data
 * @property-read Dot $redux_section_data
 * @property-read Dot $shortcode_attributes
 */
trait WithTableData
{
    protected $_table_data_instance;
    protected $_shortcode_attributes;

    protected $_redux_section_data;
    protected $_redux_module_data;

    /**
     * @return TableDataModel
     */
    public function get_table_data()
    {
        return $this->_table_data_instance;
    }

    /**
     * Пытаемся вытащить необходимые данные, если их нет отдаем пустой Dot массив
     * @param $dependencyName
     * @return Dot
     */
    private function get_table_data_dependency($dependencyName)
    {
        return $this->table_data && $this->table_data->$dependencyName
            ? $this->table_data->$dependencyName
            : new Dot();
    }

    /**
     * @return Dot
     */
    public function get_redux_module_data()
    {
        if (!$this->_redux_module_data) {
            $this->_redux_module_data = $this->get_table_data_dependency('redux_module_data');
        }
        return $this->_redux_module_data;
    }

    /**
     * @return Dot
     */
    public function get_redux_section_data()
    {
        if (!$this->_redux_section_data && $this->table_data) {
            $this->_redux_section_data = $this->get_table_data_dependency('redux_section_data');
        }
        return $this->_redux_section_data;
    }

    /**
     * @return Dot
     */
    public function get_shortcode_attributes()
    {
        if (!$this->_shortcode_attributes && $this->table_data) {
            $this->_shortcode_attributes = $this->get_table_data_dependency('shortcode_attributes');
        }
        return $this->_shortcode_attributes;
    }
}
