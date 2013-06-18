<?php

namespace Sg\CalendarBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class SgCalendarExtension
 *
 * @package Sg\CalendarBundle\DependencyInjection
 */
class SgCalendarExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('sg_calendar.event.class', $config['event_class']);
        $container->setParameter('sg_calendar.first_day', $config['first_day']);
        $container->setParameter('sg_calendar.time_format', $config['time_format']);
        $container->setParameter('sg_calendar.form.event.name', $config['form']['event_name']);
        $container->setParameter('sg_calendar.form.event.type', $config['form']['event_type']);
    }
}
