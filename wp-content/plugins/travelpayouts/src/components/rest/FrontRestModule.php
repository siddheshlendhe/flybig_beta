<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\rest;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use Travelpayouts\components\BaseInjectedObject;

/**
 * Class FrontRestModule
 * @package Travelpayouts\components\rest
 * @property-read string|int $id
 * @property-read string $name
 * @property-read array $shortcodes
 */
abstract class FrontRestModule extends BaseInjectedObject
{
    /**
     * @return string|int
     */
    abstract protected function id();

    /**
     * @return string
     */
    abstract protected function name();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name();
    }

    /**
     * @return string|int
     */
    public function getId()
    {
        return $this->id();
    }

    /**
     * @return FrontModel[]
     */
    public function getChildren()
    {
        try {
            return array_reduce($this->attributes(), function ($accumulator, $attributeName) {
                $frontModelInstance = $this->$attributeName;
                return $frontModelInstance instanceof FrontModel && $frontModelInstance::isActive()
                    ? array_merge($accumulator, [$attributeName => $frontModelInstance])
                    : $accumulator;
            }, []);
        } catch (ReflectionException $e) {
            return [];
        }
    }

    /**
     * Отдаем данные о входящих в модуль шорткодах
     * @return array
     */
    public function getShortcodes()
    {
        return array_map(static function ($model) {
            return $model->get()->data;
        }, $this->getChildren());
    }

    /**
     * @return RestRoute[]
     */
    public function getRouteModelList()
    {
        $children = $this->getChildren();
        return array_map($this->mapShortcodeRoutes($children), array_keys($children));
    }

    /**
     * @param FrontModel[] $childList
     * @return \Closure
     */
    protected function mapShortcodeRoutes($childList)
    {
        $campaignId = $this->id();

        return static function ($shortcodeName) use ($childList, $campaignId) {
            $shortcodeInstance = $childList[$shortcodeName];
            if ($shortcodeInstance::isActive()) {
                $route = new RestRoute([
                    'methods' => 'POST',
                    'callback' => [$shortcodeInstance, 'post'],
                    'args' => $shortcodeInstance->args(),
                    'permission_callback' => [$shortcodeInstance, 'isActive'],
                ]);
                $route->addRoutePart($campaignId . '/' . $shortcodeName);
                return $route;
            }
            return null;
        };
    }

    /**
     * Returns the list of attribute names.
     * By default, this method returns all public non-static properties of the class.
     * You may override this method to change the default behavior.
     * @return array list of attribute names.
     * @throws ReflectionException
     */
    private function attributes()
    {
        $class = new ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }
        return $names;
    }
}
