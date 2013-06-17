<?php

namespace Sg\CalendarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Sg\CalendarBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sg_calendar');

        $rootNode
            ->children()
                ->scalarNode('event_class')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('form')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('event_name')->defaultValue('sg_calendar_eventtype')->end()
                        ->scalarNode('event_type')->defaultValue('sg_calendar_eventtype')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
