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

### `GET` /calendar/ ###

_Shows the calendar._

Shows the calendar.


### `POST` /calendar/event/create ###

_Creates a new Event entity._

Creates a new Event entity.


### `GET` /calendar/event/new ###

_Displays a form to create a new Event entity._

Displays a form to create a new Event entity.


### `DELETE` /calendar/event/{id}/delete ###

_Deletes an Event entity._

Deletes an Event entity.

#### Requirements ####

**id**

  - Type: integer
  - Description: The entity id


### `GET` /calendar/event/{id}/edit ###

_Displays a form to edit an existing Event entity._

Displays a form to edit an existing Event entity.

#### Requirements ####

**id**

  - Type: integer
  - Description: The entity id


### `GET` /calendar/event/{id}/show ###

_Finds and displays an Event entity._

Finds and displays an Event entity.

#### Requirements ####

**id**

  - Type: integer
  - Description: The entity id


### `PUT` /calendar/event/{id}/update ###

_Edits an existing Event entity._

Edits an existing Event entity.

#### Requirements ####

**id**

  - Type: integer
  - Description: The entity id


### `GET` /calendar/events ###

_Get all Event entities._

Get all Event entities.

### Next Steps
