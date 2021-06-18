<?php

namespace Travelpayouts\Vendor\DI\Invoker;
use Travelpayouts\Vendor\Invoker\ParameterResolver\ParameterResolver;
use Travelpayouts\Vendor\Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionFunctionAbstract;

/**
 * Inject the container, the definition or any other service using type-hints.
 *
 * {@internal This class is similar to TypeHintingResolver and TypeHintingContainerResolver,
 *            we use this instead for performance reasons}
 *
 * @author Quim Calpe <quim@kalpe.com>
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class FactoryParameterResolver implements ParameterResolver
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getParameters(
        ReflectionFunctionAbstract $reflection,
        array $providedParameters,
        array $resolvedParameters
    ) {
        $parameters = $reflection->getParameters();

        // Skip parameters already resolved
        if (! empty($resolvedParameters)) {
            $parameters = array_diff_key($parameters, $resolvedParameters);
        }

        foreach ($parameters as $index => $parameter) {
			if (PHP_VERSION_ID > 80000) {
				$parameterClass = $parameter->getType() && !$parameter->getType()->isBuiltin()
					? new ReflectionClass($parameter->getType()->getName())
					: null;
			} else {
				$parameterClass = $parameter->getClass();
			}

            if (!$parameterClass) {
                continue;
            }

            if ($parameterClass->name === 'Travelpayouts\Vendor\Interop\Container\ContainerInterface'
                || $parameterClass->name === 'Travelpayouts\Vendor\Psr\Container\ContainerInterface') {
                $resolvedParameters[$index] = $this->container;
            } elseif ($parameterClass->name === 'Travelpayouts\Vendor\DI\Factory\RequestedEntry') {
                // By convention the second parameter is the definition
                $resolvedParameters[$index] = $providedParameters[1];
            } elseif ($this->container->has($parameterClass->name)) {
                $resolvedParameters[$index] = $this->container->get($parameterClass->name);
            }
        }

        return $resolvedParameters;
    }
}
