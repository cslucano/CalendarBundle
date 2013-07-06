# SgCalendarBundle

This Bundle integrates the jQuery FullCalendar plugin into your Symfony2 application. Compatible with Doctrine ORM.

**Status:** not yet ready, hard-development.

## Installation

### Prerequisites

* This version of the bundle requires Symfony 2.3.x.
* Also FOSUserBundle needs to be installed and configured beforehand. Please follow all steps described [here](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md).

### Translations

``` yaml
# app/config/config.yml

framework:
    translator: { fallback: %locale% }

    # ...

    default_locale:  "%locale%"
```

### Step 1: Download SgCalendarBundle using composer

Add SgCalendarBundle in your composer.json:

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

Composer will install the bundle to your project's `vendor/sg` directory.

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

## The Calendar class

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

}
```

## The Event class

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

### Step 5: Configure your Doctrine ORM User class as target entity

Configure it in your `config.yml`:

``` yaml
# app/config/config.yml

doctrine:
    orm:
        # ...
        resolve_target_entities:
            Symfony\Component\Security\Core\User\UserInterface: Sg\UserBundle\Entity\User # Your custom class from above
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

### Step 8: Assets

Add the required stylesheet and javascripts to your layout.

A layout.html.twig can look like this:

``` html
{% extends '::base.html.twig' %}

{% block title %}CalendarBundle{% endblock %}

{% block stylesheets %}

    <link href="{{ asset('bundles/sgcalendar/css/fullcalendar.css') }}" rel="stylesheet" type="text/css" />

{% endblock %}

{% block body%}

    {% block scripts %}

        <script src="{{ asset('bundles/sgcalendar/js/jquery-2.0.2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bundles/sgcalendar/js/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bundles/sgcalendar/js/fullcalendar.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bundles/sgcalendar/js/gcal.js') }}" type="text/javascript"></script>

    {% endblock %}

    <div class="container">

        {% if is_granted("IS_AUTHENTICATED_REMEMBERED") %}
            {{ 'layout.logged_in_as'|trans({'%username%': app.user.username}, 'FOSUserBundle') }} |
            <a href="{{ path('fos_user_security_logout') }}">
                {{ 'layout.logout'|trans({}, 'FOSUserBundle') }}
            </a>
        {% else %}
            <a href="{{ path('fos_user_security_login') }}">{{ 'layout.login'|trans({}, 'FOSUserBundle') }}</a>
        {% endif %}

        {% for type, messages in app.session.flashbag.all() %}
            {% for message in messages %}
                <div class="flash-{{ type }}">
                    {{ message }}
                </div>
            {% endfor %}
        {% endfor %}

        {% block content %}
        {% endblock %}
    </div>

{% endblock %}
```

### Routing

<div style="text-align:center"><img alt="Routes" src="https://github.com/stwe/CalendarBundle/raw/master/Resources/doc/routes.jpg"></div>

### Next Steps

- [Overriding Forms](https://github.com/stwe/CalendarBundle/blob/master/Resources/doc/overriding_forms.md)
