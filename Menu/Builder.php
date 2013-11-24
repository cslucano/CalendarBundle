<?php

/**
 * This file is part of the SgCalendarBundle package.
 *
 * (c) stwe <https://github.com/stwe/CalendarBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\CalendarBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class Builder
 *
 * @package Sg\CalendarBundle\Menu
 */
class Builder extends ContainerAware
{
    /**
     * MainMenu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $request = $this->container->get('request');
        $route = $request->attributes->get('_route');
        $routeParams = $request->attributes->get('_route_params');
        $german = array('_locale' => 'de');
        $english = array('_locale' => 'en');

        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        // Calendar, Event
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $menu->addChild('menu.calendar')
                ->setAttribute('dropdown', true);
            $menu->addChild('menu.event')
                ->setAttribute('dropdown', true);
            $menu['menu.calendar']->addChild('menu.new_calendar', array('route' => 'sg_calendar_new_calendar'));
            $menu['menu.event']->addChild('menu.new_event', array('route' => 'sg_calendar_new_event'));
        }

        // User
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $menu->addChild('menu.user')
                ->setAttribute('dropdown', true);
            $menu['menu.user']->addChild('menu.user_profile', array('route' => 'fos_user_profile_show'));
            $menu['menu.user']->addChild('menu.user_profile_edit', array('route' => 'fos_user_profile_edit'));
            $menu['menu.user']->addChild('menu.user_profile_change_password', array('route' => 'fos_user_change_password'));
        }

        // Language
        $menu->addChild('menu.language')
            ->setAttribute('dropdown', true);
        $menu['menu.language']->addChild('menu.german', array(
                'route' => $route,
                'routeParameters' => array_replace($routeParams, $german)
            ));
        $menu['menu.language']->addChild('menu.english', array(
                'route' => $route,
                'routeParameters' => array_replace($routeParams, $english)
            ));

        return $menu;
    }
} 