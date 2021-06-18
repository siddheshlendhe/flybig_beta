<?php

namespace Travelpayouts\Vendor\Invoker\ParameterResolver\Container;
use Travelpayouts\Vendor\Interop\Container\ContainerInterface;
use Travelpayouts\Vendor\Invoker\ParameterResolver\ParameterResolver;
use ReflectionClass;
use ReflectionFunctionAbstract;

/**
 * Inject entries from a DI container using the type-hints.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class TypeHintContainerResolver implements ParameterResolver
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container The container to get entries from.
     */
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

            if ($parameterClass && $this->container->has($parameterClass->name)) {
                $resolvedParameters[$index] = $this->container->get($parameterClass->name);
            }
        }

        return $resolvedParameters;
    }
}
