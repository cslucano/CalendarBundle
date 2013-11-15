<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
                ->scalarNode('calendar_class')->defaultValue('Sg\CalendarBundle\Entity\Calendar')->end()
                ->scalarNode('event_class')->defaultValue('Sg\CalendarBundle\Entity\Event')->end()
                ->scalarNode('reminder_class')->defaultValue('Sg\CalendarBundle\Entity\Reminder')->end()
                ->scalarNode('rrule_class')->defaultValue('Sg\RruleBundle\Entity\Rrule')->end()
                ->scalarNode('occurrence_class')->defaultValue('Sg\RruleBundle\Entity\Occurrence')->end()
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

                // mailer
                ->arrayNode('from_email')
                    ->children()
                        ->scalarNode('address')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('sender_name')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
