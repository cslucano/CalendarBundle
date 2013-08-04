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
                // doctrine
                ->scalarNode('calendar_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('event_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('recurrence_class')->defaultValue('Sg\CalendarBundle\Entity\Recurrence')->end()
                ->scalarNode('calculation_class')->defaultValue('Sg\CalendarBundle\Entity\Calculation')->end()
                ->integerNode('calendar_max_results')
                    ->defaultValue(10)
                    ->min(1)
                ->end()

                // twig
                ->scalarNode('fullcalendar_id')->defaultValue('sg_fullcalendar')->end()
                ->scalarNode('datepicker_id')->defaultValue('sg_datepicker')->end()
                ->scalarNode('first_day')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('time_format')->isRequired()->cannotBeEmpty()->end()

                // forms
                ->arrayNode('form')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('event_name')->defaultValue('sg_calendar_eventtype')->end()
                        ->scalarNode('event_type')->defaultValue('sg_calendar_eventtype')->end()
                        ->scalarNode('calendar_name')->defaultValue('sg_calendar_calendartype')->end()
                        ->scalarNode('calendar_type')->defaultValue('sg_calendar_calendartype')->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
