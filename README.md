# SgCalendarBundle

This Bundle integrates the jQuery FullCalendar plugin into your Symfony2 application. Compatible with Doctrine ORM.

**Status:** not yet ready, hard-development.

## Screenshot

<div style="text-align:center"><img alt="Routes" src="https://github.com/stwe/CalendarBundle/raw/master/Resources/doc/screen.jpg"></div>

## Access Control

* An admin (ROLE_ADMIN) has full access.
* Each authenticated user can create calendars and events.
* Each authenticated user can view, edit and delete their own calendar and events.
* All guests can see all public calendars.

## GCal Sources

FullCalendar can display events from a public Google Calendar.
These addresses can be entered using the calendar form.

## Installation

### Prerequisites

* This version of the bundle requires Symfony 2.3.x.
* Also FOSUserBundle needs to be installed and configured beforehand. Please follow all steps described [here](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md).
* Finally, Bootstrap 2.3.x and FullCalendar 1.6.1 should be installed.

Your composer.json should look like this:

```js
{
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "arshaw/fullcalendar",
                "version": "1.6.1",
                "dist": {
                    "type": "zip",
                    "url": "http://arshaw.com/fullcalendar/downloads/fullcalendar-1.6.1.zip"
                }
            }
        }
    ],
    "require": {
        "friendsofsymfony/user-bundle": "2.0.*@dev",
        "arshaw/fullcalendar": "1.6.1",
        "twitter/bootstrap": "2.3.*",
        "sg/calendarbundle": "dev-master"
    },
}
```

### Translations

``` yaml
# app/config/config.yml

framework:
    translator: { fallback: %locale% }

    # ...

    default_locale:  "%locale%"
```

### Step 1: Download SgCalendarBundle using composer

If not already done: add SgCalendarBundle in your composer.json:

```js
{
    "require": {
        "sg/calendarbundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update sg/calendarbundle
```

or get the latest versions of all bundles:

``` bash
$ php composer.phar update
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Sg\CalendarBundle\SgCalendarBundle(),
    );
}
```

### Step 3: Create your Doctrine ORM classes

#### The Calendar class

``` php
<?php
// src/Sg/UserBundle/Entity/Calendar.php

namespace Sg\UserBundle\Entity;

use Sg\CalendarBundle\Model\AbstractCalendar as BaseCalendar;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Calendar
 *
 * @ORM\Entity()
 * @ORM\Table()
 *
 * @package Sg\UserBundle\Entity
 */
class Calendar extends BaseCalendar
{
    /**
     * Ctor.
     */
    public function __construct()
    {
        parent::__construct();

        // your own logic
    }
}
```

#### The Event class

``` php
<?php
// src/Sg/UserBundle/Entity/Event.php

namespace Sg\UserBundle\Entity;

use Sg\CalendarBundle\Model\AbstractEvent as BaseEvent;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Event
 *
 * @ORM\Entity()
 * @ORM\Table()
 *
 * @package Sg\UserBundle\Entity
 */
class Event extends BaseEvent
{
    /**
     * Ctor.
     */
    public function __construct()
    {
        parent::__construct();

        // your own logic
    }
}
```

### Step 4: Implement the EquatableInterface in your Doctrine ORM User class

``` php
<?php
// src/Sg/UserBundle/Entity/User.php

namespace Sg\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser implements EquatableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * {@inheritdoc}
     */
    public function isEqualTo(UserInterface $user)
    {
        return md5($user->getUsername()) == md5($this->getUsername()) &&
            md5(serialize($user->getRoles())) == md5(serialize($this->getRoles()));
    }
}
```

### Step 5: Configure your Doctrine ORM classes as target entities

Configure it in your `config.yml`:

``` yaml
# app/config/config.yml

doctrine:
    orm:
        # ...
        resolve_target_entities:
            Symfony\Component\Security\Core\User\UserInterface: Sg\UserBundle\Entity\User
            Sg\CalendarBundle\Model\CalendarInterface: Sg\UserBundle\Entity\Calendar
            Sg\CalendarBundle\Model\EventInterface: Sg\UserBundle\Entity\Event
```

### Step 6: Configure the SgCalendarBundle

Add the following configuration to your `config.yml` file:

``` yaml
# app/config/config.yml

sg_calendar:
    calendar_class: Sg\UserBundle\Entity\Calendar # or SgUserBundle:Calendar
    event_class: Sg\UserBundle\Entity\Event # or SgUserBundle:Event
    first_day: 1 # Monday
    time_format: "HH:mm"
```

### Step 7: Update your database schema

``` bash
$ php app/console doctrine:schema:update --force
```

### Step 8: Assetic Configuration

``` yaml
# app/config/config.yml

assetic:
    debug:          %kernel.debug%
    use_controller: false
    bundles:        [ SgCalendarBundle ]
    #java: /usr/bin/java
    filters:
        cssrewrite: ~
    assets:
       jquery_js:
           inputs:
               - %kernel.root_dir%/../vendor/arshaw/fullcalendar/jquery/jquery-1.9.1.min.js
       bootstrap_css:
           inputs:
               - %kernel.root_dir%/../vendor/twitter/bootstrap/docs/assets/css/bootstrap.css
       bootstrap_js:
           inputs:
               - %kernel.root_dir%/../vendor/twitter/bootstrap/docs/assets/js/bootstrap.js
       fullcalendar_css:
           inputs:
               - %kernel.root_dir%/../vendor/arshaw/fullcalendar/fullcalendar/fullcalendar.css
       fullcalendar_js:
           inputs:
               - %kernel.root_dir%/../vendor/arshaw/fullcalendar/fullcalendar/fullcalendar.js
               - %kernel.root_dir%/../vendor/arshaw/fullcalendar/fullcalendar/gcal.js
```

This bundle provides a layout that uses the Bootstrap framework.
The bundle layout file is: `src/Sg/CalendarBundle/Resources/views/layout.html.twig`. This is only an example and can be replaced.

``` html
{% extends '::base.html.twig' %}

{% block title %}CalendarBundle{% endblock %}

{% block stylesheets %}
    {% stylesheets
        '@bootstrap_css'
        '@fullcalendar_css'
        'bundles/sgcalendar/css/smoothness/jquery-ui-1.10.3.custom.min.css'
        filter='cssrewrite' %}
        <link href="{{ asset_url }}" rel="stylesheet" type="text/css"/>
    {% endstylesheets %}
{% endblock %}

{% block body%}

    {% block scripts %}
        {% javascripts
            '@jquery_js'
            '@bootstrap_js'
            '@fullcalendar_js'
            'bundles/sgcalendar/js/jquery-ui-1.10.3.custom.min.js'
            'bundles/sgcalendar/js/jquery.ui.datepicker-de.js'
            'bundles/sgcalendar/js/sgcalendar.js' %}
            <script type="text/javascript" src="{{ asset_url }}"></script>
        {% endjavascripts %}
    {% endblock %}

    <script>
        global = {
            locale : "{{ app.request.locale }}"
        }
        $(document).ready(function() {
            sg_calendar_datepicker.initLocale();
            sg_calendar_datepicker.initDatePicker();
        });
    </script>

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="{{ path('sg_calendar') }}">SgCalendarBundle</a>
                <div class="nav-collapse collapse">
                    <ul class="nav">
                        {% if is_granted("IS_AUTHENTICATED_REMEMBERED") %}
                            <li>
                                <a href="{{ path('fos_user_profile_show') }}">
                                    {{ 'layout.logged_in_as'|trans({'%username%': app.user.username}, 'FOSUserBundle') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ path('fos_user_security_logout') }}">
                                    {{ 'layout.logout'|trans({}, 'FOSUserBundle') }}
                                </a>
                            </li>
                        {% else %}
                            <li>
                                <a href="{{ path('fos_user_security_login') }}">{{ 'layout.login'|trans({}, 'FOSUserBundle') }}</a>
                            </li>
                        {% endif %}
                        <li>
                            <a href="#" class="pull-right">Locale: {{ app.request.locale }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 45px;">
        <div class="row">
            <div class="span12">
                {% block header %}
                {% endblock %}
            </div>
        </div>
        <div class="row">
            <div class="span4">
                {% block sidebar %}
                {% endblock %}
            </div>
            <div class="span8">
                {% for type, messages in app.session.flashbag.all() %}
                    {% for message in messages %}
                        <div class="alert alert-{{ type }}">
                            <button class="close" data-dismiss="alert" type="button">×</button>
                            {{ message }}
                        </div>
                    {% endfor %}
                {% endfor %}
                {% block content %}
                {% endblock %}
            </div>
        </div>
    </div>

{% endblock %}
```

## Routing

<div style="text-align:center"><img alt="Routes" src="https://github.com/stwe/CalendarBundle/raw/master/Resources/doc/routes.jpg"></div>

## Next Steps

- [Overriding Forms](https://github.com/stwe/CalendarBundle/blob/master/Resources/doc/overriding_forms.md)
