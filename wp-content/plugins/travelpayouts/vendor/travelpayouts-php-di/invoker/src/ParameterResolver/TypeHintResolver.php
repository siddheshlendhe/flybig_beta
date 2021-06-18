<?php

namespace Travelpayouts\Vendor\Invoker\ParameterResolver;

use ReflectionClass;
use ReflectionFunctionAbstract;

/**
 * Inject entries using type-hints.
 * Tries to match type-hints with the parameters provided.
 * @author Felix Becker <f.becker@outlook.com>
 */
class TypeHintResolver implements ParameterResolver
{
	public function getParameters(
		ReflectionFunctionAbstract $reflection,
		array $providedParameters,
		array $resolvedParameters
	)
	{
		$parameters = $reflection->getParameters();

		// Skip parameters already resolved
		if (!empty($resolvedParameters)) {
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

			if ($parameterClass && array_key_exists($parameterClass->name, $providedParameters)) {
				$resolvedParameters[$index] = $providedParameters[$parameterClass->name];
			}
		}

		return $resolvedParameters;
	}
}
