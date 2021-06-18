<?php

namespace Travelpayouts\Vendor\DI\Definition\Resolver;
use Travelpayouts\Vendor\DI\Definition\Definition;
use Travelpayouts\Vendor\DI\Definition\SelfResolvingDefinition;
use Travelpayouts\Vendor\Psr\Container\ContainerInterface;

/**
 * Resolves self-resolving definitions.
 *
 * @since 5.3
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class SelfResolver implements DefinitionResolver
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param SelfResolvingDefinition $definition
     *
     * {@inheritdoc}
     */
    public function resolve(Definition $definition, array $parameters = [])
    {
        return $definition->resolve($this->container);
    }

    /**
     * @param SelfResolvingDefinition $definition
     *
     * {@inheritdoc}
     */
    public function isResolvable(Definition $definition, array $parameters = [])
    {
        return $definition->isResolvable($this->container);
    }
}
