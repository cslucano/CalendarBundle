# SgCalendarBundle

This Bundle integrates the jQuery FullCalendar plugin into your Symfony2 application.

**Status:** not yet ready, hard-development.

## Installation

### Prerequisites

This version of the bundle requires Symfony 2.3.x.

### Translations

``` yaml
# app/config/config.yml

framework:
    translator: { fallback: %locale% }
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

### Step 3: Create your Doctrine ORM Event class

``` php
<?php
// src/Sg/UserBundle/Entity/Event.php

namespace Sg\UserBundle\Entity;

use Sg\CalendarBundle\Entity\Event as BaseEvent;
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
}
```

### Step 4: Configure the SgCalendarBundle

Add the following configuration to your `config.yml` file:

``` yaml
# app/config/config.yml

sg_calendar:
    event_class: Sg\UserBundle\Entity\Event # or SgUserBundle:Event
    first_day: 1
    time_format: "HH:mm"
```

### Step 5: Update your database schema

``` bash
$ php app/console doctrine:schema:update --force
```

### Step 6: Assets

Add the required stylesheet and javascripts to your layout.

A layout.html.twig for your bundle can look like this:

``` html
{% extends '::base.html.twig' %}

{% block title %}CalendarBundle{% endblock %}

{% block stylesheets %}

    <link href="{{ asset('bundles/sgcalendar/css/fullcalendar.css') }}" rel="stylesheet" type="text/css" />

{% endblock %}

{% block body%}

    {% block scripts %}

        <script src="{{ asset('bundles/sgcalendar/js/jquery-2.0.2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bundles/sgcalendar/js/fullcalendar.min.js') }}" type="text/javascript"></script>

    {% endblock %}

    <div class="container">
        {% block content %}
        {% endblock %}
    </div>

{% endblock %}
```

### Step 7: Routing

sg_calendar_show                  GET      ANY    ANY  /calendar/

sg_calendar_events                GET      ANY    ANY  /calendar/events

sg_calendar_event_create          POST     ANY    ANY  /calendar/event/create

sg_calendar_event_new             GET      ANY    ANY  /calendar/event/new

sg_calendar_event_show            GET      ANY    ANY  /calendar/event/{id}

sg_calendar_event_edit            GET      ANY    ANY  /calendar/event/{id}/edit

sg_calendar_event_update          PUT      ANY    ANY  /calendar/event/{id}/update

sg_calendar_event_delete          DELETE   ANY    ANY  /calendar/event/{id}/delete

### Next Steps
