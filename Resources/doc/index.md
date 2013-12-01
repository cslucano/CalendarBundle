# Getting Started With SgCalendarBundle

This Bundle integrates the jQuery FullCalendar plugin into your Symfony2 application. Compatible with Doctrine ORM.

*WARNING*: This is not a final/stable bundle.

## Access Control

* An admin (ROLE_ADMIN) has full access.
* Each authenticated user can create calendars and events.
* Each authenticated user can view, edit and delete their own calendar and events.

## GCal Sources

FullCalendar can display events from a public Google Calendar.
These addresses can be entered using the calendar form.

## Installation

### Prerequisites

* This version of the bundle requires Symfony 2.3.x.
* Also FOSUserBundle needs to be installed and configured beforehand. Please follow all steps described [here](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md).
* KnpMenuBundle needs to be installed and configured beforehand. Please follow all steps described [here](https://github.com/KnpLabs/KnpMenuBundle/blob/master/Resources/doc/index.md).
* The SgRruleBundle is part of SgCalendarBundle and must be installed.
* Finally, Bootstrap 2.3.2 and FullCalendar 1.6 should be installed.

Your composer.json should look like this:

```js
{
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "arshaw/fullcalendar",
                "version": "1.6.4",
                "dist": {
                    "type": "zip",
                    "url": "http://arshaw.com/fullcalendar/downloads/fullcalendar-1.6.4.zip"
                }
            }
        }
    ],
    "require": {
        "friendsofsymfony/user-bundle": "2.0.*@dev",
        "knplabs/knp-menu-bundle":"dev-master",
        "knplabs/knp-menu": "2.0.*@dev",
        "sg/rrulebundle": "dev-master",
        "twbs/bootstrap": "v2.3.2",
        "arshaw/fullcalendar": "1.6.4",
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

### Step 3: Implement the EquatableInterface and CalendarUserInterface in your Doctrine ORM User class

``` php
<?php
// src/Sg/UserBundle/Entity/User.php

namespace Sg\UserBundle\Entity;

use Sg\CalendarBundle\Model\CalendarInterface;
use Sg\CalendarBundle\Model\CalendarUserInterface;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Doctrine\ORM\Mapping\JoinTable as JoinTable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 * @package Sg\UserBundle\Entity
 */
class User extends BaseUser implements EquatableInterface, CalendarUserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Many users have Many favorite calendars.
     *
     * @ORM\ManyToMany(
     *     targetEntity="Sg\CalendarBundle\Model\CalendarInterface",
     *     inversedBy="userFavorites"
     * )
     * @JoinTable(
     *     name="user_favorite_calendars",
     *     joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="favorite_calendar_id", referencedColumnName="id")}
     * )
     */
    protected $favorites;


    /**
     * Ctor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->favorites = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function isEqualTo(UserInterface $user)
    {
        return md5($user->getUsername()) == md5($this->getUsername()) &&
        md5(serialize($user->getRoles())) == md5(serialize($this->getRoles()));
    }

    /**
     * {@inheritdoc}
     */
    public function addFavorite(CalendarInterface $favorite)
    {
        $this->favorites[] = $favorite;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeFavorite(CalendarInterface $favorite)
    {
        $this->favorites->removeElement($favorite);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFavorites()
    {
        return $this->favorites;
    }
}
```

### Step 4: Configure your Doctrine ORM classes as target entities

Configure it in your `config.yml`:

``` yaml
# app/config/config.yml

doctrine:
    orm:
        # ...
        resolve_target_entities:
            Sg\RruleBundle\Model\RruleInterface: Sg\RruleBundle\Entity\Rrule              # SgRruleBundle default
            Sg\RruleBundle\Model\OccurrenceInterface: Sg\RruleBundle\Entity\Occurrence    # SgRruleBundle default
            Sg\CalendarBundle\Model\CalendarInterface: Sg\CalendarBundle\Entity\Calendar  # SgCalendarBundle default
            Sg\CalendarBundle\Model\EventInterface: Sg\CalendarBundle\Entity\Event        # SgCalendarBundle default
            Sg\CalendarBundle\Model\ReminderInterface: Sg\CalendarBundle\Entity\Reminder  # SgCalendarBundle default
            Symfony\Component\Security\Core\User\UserInterface: Sg\UserBundle\Entity\User # your User entity
```

### Step 5: Configure the SgCalendarBundle

Add the following configuration to your `config.yml` file:

``` yaml
# app/config/config.yml

sg_calendar:
    first_day: 1 # Monday
    time_format: "HH:mm"
    #...
```

The bundle uses `Swiftmailer` to send emails.
To configure the sender email address for all emails sent out by the bundle, simply update your config as follows:

``` yaml
# app/config/config.yml

sg_calendar:
    #...
    from_email:
        address:        noreply@acmedemo.com
        sender_name:    Calendar Demo App
```

### Step 6: Import routing

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml

# SgRruleBundle
sg_rrule:
    resource: "@SgRruleBundle/Controller/"
    type:     annotation
    prefix:   /

# SgCalendarBundle
sg_calendar:
    resource: "@SgCalendarBundle/Controller/"
    type:     annotation
    prefix:   /
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
               - %kernel.root_dir%/../vendor/arshaw/fullcalendar/lib/jquery.min.js
           output: js/jquery.js
       img_bootstrap_glyphicons_black:
           inputs:
               - %kernel.root_dir%/../vendor/twbs/bootstrap/img/glyphicons-halflings.png
           output: img/glyphicons-halflings.png
       img_bootstrap_glyphicons_white:
           inputs:
               - %kernel.root_dir%/../vendor/twbs/bootstrap/img/glyphicons-halflings-white.png
           output: img/glyphicons-halflings-white.png
       bootstrap_css:
           inputs:
               - %kernel.root_dir%/../vendor/twbs/bootstrap/docs/assets/css/bootstrap.css
           output: css/bootstrap.css
       bootstrap_js:
           inputs:
               - %kernel.root_dir%/../vendor/twbs/bootstrap/docs/assets/js/bootstrap.js
           output: js/bootstrap.js
       fullcalendar_css:
           inputs:
               - %kernel.root_dir%/../vendor/arshaw/fullcalendar/fullcalendar/fullcalendar.css
           output: css/fullcalendar.css
       fullcalendar_js:
           inputs:
               - %kernel.root_dir%/../vendor/arshaw/fullcalendar/fullcalendar/fullcalendar.min.js
               - %kernel.root_dir%/../vendor/arshaw/fullcalendar/fullcalendar/gcal.js
           output: js/fullcalendar.js
```

This bundle provides a layout that uses the Bootstrap framework.
The bundle layout file is: `src/Sg/CalendarBundle/Resources/views/layout.html.twig`. This is only an example and can be replaced.

## Next Steps

- [Overriding Forms](https://github.com/stwe/CalendarBundle/blob/master/Resources/doc/overriding_forms.md)
