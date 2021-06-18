<?php

namespace Travelpayouts\Vendor\DI;
use Travelpayouts\Vendor\DI\Definition\EntryReference;
use Travelpayouts\Vendor\DI\Definition\Helper\ArrayDefinitionExtensionHelper;
use Travelpayouts\Vendor\DI\Definition\Helper\EnvironmentVariableDefinitionHelper;
use Travelpayouts\Vendor\DI\Definition\Helper\FactoryDefinitionHelper;
use Travelpayouts\Vendor\DI\Definition\Helper\ObjectDefinitionHelper;
use Travelpayouts\Vendor\DI\Definition\Helper\StringDefinitionHelper;
use Travelpayouts\Vendor\DI\Definition\Helper\ValueDefinitionHelper;

if (! function_exists('Travelpayouts\Vendor\DI\value')) {
    /**
     * Helper for defining a value.
     *
     * @param mixed $value
     *
     * @return ValueDefinitionHelper
     */
    function value($value)
    {
        return new ValueDefinitionHelper($value);
    }
}

if (! function_exists('Travelpayouts\Vendor\DI\object')) {
    /**
     * Helper for defining an object.
     *
     * @param string|null $className Class name of the object.
     *                               If null, the name of the entry (in the container) will be used as class name.
     *
     * @return ObjectDefinitionHelper
     */
    function object($className = null)
    {
        return new ObjectDefinitionHelper($className);
    }
}

if (! function_exists('Travelpayouts\Vendor\DI\factory')) {
    /**
     * Helper for defining a container entry using a factory function/callable.
     *
     * @param callable $factory The factory is a callable that takes the container as parameter
     *                          and returns the value to register in the container.
     *
     * @return FactoryDefinitionHelper
     */
    function factory($factory)
    {
        return new FactoryDefinitionHelper($factory);
    }
}

if (! function_exists('Travelpayouts\Vendor\DI\decorate')) {
    /**
     * Decorate the previous definition using a callable.
     *
     * Example:
     *
     *     'foo' => decorate(function ($foo, $container) {
     *         return new CachedFoo($foo, $container->get('cache'));
     *     })
     *
     * @param callable $callable The callable takes the decorated object as first parameter and
     *                           the container as second.
     *
     * @return FactoryDefinitionHelper
     */
    function decorate($callable)
    {
        return new FactoryDefinitionHelper($callable, true);
    }
}

if (! function_exists('Travelpayouts\Vendor\DI\get')) {
    /**
     * Helper for referencing another container entry in an object definition.
     *
     * @param string $entryName
     *
     * @return EntryReference
     */
    function get($entryName)
    {
        return new EntryReference($entryName);
    }
}

if (! function_exists('Travelpayouts\Vendor\DI\link')) {
    /**
     * Helper for referencing another container entry in an object definition.
     *
     * @deprecated \Travelpayouts\Vendor\DI\link() has been replaced by \Travelpayouts\Vendor\DI\get()
     *
     * @param string $entryName
     *
     * @return EntryReference
     */
    function link($entryName)
    {
        return new EntryReference($entryName);
    }
}

if (! function_exists('Travelpayouts\Vendor\DI\env')) {
    /**
     * Helper for referencing environment variables.
     *
     * @param string $variableName The name of the environment variable.
     * @param mixed $defaultValue The default value to be used if the environment variable is not defined.
     *
     * @return EnvironmentVariableDefinitionHelper
     */
    function env($variableName, $defaultValue = null)
    {
        // Only mark as optional if the default value was *explicitly* provided.
        $isOptional = 2 === func_num_args();

        return new EnvironmentVariableDefinitionHelper($variableName, $isOptional, $defaultValue);
    }
}

if (! function_exists('Travelpayouts\Vendor\DI\add')) {
    /**
     * Helper for extending another definition.
     *
     * Example:
     *
     *     'log.backends' => \Travelpayouts\Vendor\DI\add(DI\get('My\Custom\LogBackend'))
     *
     * or:
     *
     *     'log.backends' => \Travelpayouts\Vendor\DI\add([
     * \Travelpayouts\Vendor\DI\get('My\Custom\LogBackend')
     *     ])
     *
     * @param mixed|array $values A value or an array of values to add to the array.
     *
     * @return ArrayDefinitionExtensionHelper
     *
     * @since 5.0
     */
    function add($values)
    {
        if (! is_array($values)) {
            $values = [$values];
        }

        return new ArrayDefinitionExtensionHelper($values);
    }
}

if (! function_exists('Travelpayouts\Vendor\DI\string')) {
    /**
     * Helper for concatenating strings.
     *
     * Example:
     *
     *     'log.filename' => \Travelpayouts\Vendor\DI\string('{app.path}/app.log')
     *
     * @param string $expression A string expression. Use the `{}` placeholders to reference other container entries.
     *
     * @return StringDefinitionHelper
     *
     * @since 5.0
     */
    function string($expression)
    {
        return new StringDefinitionHelper((string) $expression);
    }
}
