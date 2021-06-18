<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\admin\redux\base;
use Travelpayouts\Vendor\Adbar\Dot;

/**
 * Class ModuleSection
 * @property-read array $section
 * @property-read Dot $data
 * @property-read ModuleSection|SectionFields[] $children
 */
abstract class ModuleSection extends Base implements IModuleSection
{
    /**
     * @var Dot
     */
    private $_data;

    /**
     * @var bool
     */
    private $isRegistered = false;

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function section()
    {
        return [];
    }

    /**
     * Добавляем необходимые префиксы к полям и возвращаем
     * @return array
     */
    public function getFields()
    {
        $fields = $this->fields();
        return $fields && is_array($fields) ? Helper::addPrefixToFields($fields, $this->optionPath) : [];
    }

    /**
     * Получаем поля дочерних классов
     * @return array
     */
    public function getChildrenFields()
    {
        return array_reduce($this->getChildren(), static function ($accumulator, $child) {
            $fields = $child->getFields();
            return is_array($fields) ? array_merge($accumulator, $fields) : $accumulator;
        }, []);
    }

    /**
     * @return Dot
     */
    public function getData()
    {
        if (!$this->_data) {
            // Сливаем данные родительской секции с дочерними
            $data = array_merge($this->getOptionPathData(), $this->getChildrenData());
            $this->_data = new Dot($data);
        }
        return $this->_data;
    }

    /**
     * Получаем данные дочерних элементов
     * @return array
     */
    private function getChildrenData()
    {
        return array_reduce($this->getChildren(), static function ($accumulator, $child) {
            $data = $child->getData();
            $path = $child->optionPath();
            return $data && $data instanceof Dot ? array_merge($accumulator, [
                $path => $data->all(),
            ]) : $accumulator;
        }, []);
    }

    /**
     * Получаем массив данных для секции redux
     * @return array
     * @see Redux::setSection()
     */
    protected function getSection()
    {
        $fields = empty($this->getFields()) ? $this->getChildrenFields() : $this->getFields();
        return array_merge($this->section(), [
            'id' => $this->optionPath,
            'subsection' => (bool)$this->parent,
            'fields' => $fields,
        ]);
    }

    protected function registerSectionInRedux()
    {
        if (!$this->isRegistered) {
            if (static::isActive()) {
                $this->redux->section($this->getSection());
            }
            $this->isRegistered = true;
        }
    }

    /**
     * Регистрируем секцию и входящие подсекции в redux
     */
    public function register()
    {
        $instanceList = array_merge([$this], $this->getChildren());
        $sections = array_filter($instanceList, static function ($instance) {
            return $instance instanceof ModuleSection;
        });

        array_walk($sections, static function ($instance) {
            /**
             * @var self $instance
             */
            $instance->registerSectionInRedux();
        });
    }
}
