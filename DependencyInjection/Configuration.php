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
                ->scalarNode('event_form_type')->isRequired()->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}
