<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\admin\redux\base;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use InvalidArgumentException;
use Travelpayouts\components\BaseInjectedObject;
use Travelpayouts\includes\ReduxConfigurator;

/**
 * Class Base
 * @package Travelpayouts\admin\redux\base
 * @property-read string $id
 * @property-read string $optionPath
 * @property-read null|Base $parent
 */
abstract class Base extends BaseInjectedObject implements IModuleSectionFields
{
	/**
	 * @Inject
	 * @var ReduxConfigurator
	 */
	public $redux;
    /**
     * @var Base[]
     */
    private $_children = [];
    /**
     * @var Base
     * @see getParent()
     * @see setParent()
     */
    private $_parent;

    /**
     * Активна ли секция/подсекция
     * В случае false регистрации секции/подсекции/полей не происходит
     * @return bool
     */
    public static function isActive()
    {
        return true;
    }

    /**
     * Инициализируем базовый класс для Redux секции/подсекции/полей
     * В случае если указана переменная $parent появится возможность обратиться к
     * родительскому классу, а также в родительский класс будет добавлен текущий класс
     * как дочерний для последующего взаимодействия между ними
     * @param Base| null $parent
     * @param array $config
     */
    public function __construct($parent = null, $config = [])
    {
        if ($parent) {
            if (!$parent instanceof self) {
                throw new InvalidArgumentException('$parent must extends ' . self::class);
            }
            $this->setParent($parent);
        }
        parent::__construct($config);
    }

    /**
     * Заполняем аттрибуты из данных redux
     */
    public function init()
    {
        foreach ($this->data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return Base
     */
    protected function getParent()
    {
        return $this->_parent;
    }

    /**
     * Устанавливаем родительский класс
     * @param Base $parent
     */
    final protected function setParent(Base $parent)
    {
        if (!$this->_parent) {
            $this->_parent = $parent;
            // добавляем родителю дочерний класс
            $this->_parent->setChildren($this);
        }
    }

    /**
     * @param Base $value
     */
    public function setChildren($value)
    {
        $this->_children = array_merge($this->_children, [$value]);
    }

    /**
     * @return Base[]
     */
    final protected function getChildren()
    {
        return $this->_children;
    }

    /**
     * @inheritdoc
     */
    final public function getOptionPath()
    {
        return $this->parent
            ?
            $this->parent->getOptionPath() . '_' . $this->optionPath()
            : $this->optionPath();
    }

    /**
     * Возвращаем путь данной опции
     * @return string
     * @see optionPath()
     */
    final public function getId()
    {
        return $this->optionPath();
    }


    /**
     * Получаем отфильтрованные данные из redux опции
     * @return array
     */
    final protected function getOptionPathData()
    {
        $options = $this->redux->get_options();
        return $options && !empty($options)
            ? Helper::getDataFromReduxOption($options, $this->optionPath)
            : [];
    }
}
