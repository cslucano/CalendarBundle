# Overriding Default Forms

Suppose that you have created an event class. In this class, you have added a `location` property.

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
    /**
     * The event's location
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $location;


    /**
     * Ctor.
     */
    public function __construct()
    {
        parent::__construct();

        // your own logic
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Event
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
}
```

Create a new form type in your own bundle.

``` php
<?php
// src/Sg/UserBundle/Form/Type/EventType.php

namespace Sg\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Sg\CalendarBundle\Form\Type\EventType as BaseType;

/**
 * Class EventType
 *
 * @package Sg\UserBundle\Form\Type
 */
class EventType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // custom field
        $builder->add('location');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sg_user_eventtype';
    }
}
```

Now that you have created your custom form type, you must declare it as a service and add a tag to it.

``` yaml
# src/UserBundle/Resources/config/services.yml

services:
    sg_user.form_type.event:
        class: Sg\UserBundle\Form\Type\EventType
        arguments: [%sg_calendar.event.class%]
        tags:
            - { name: form.type, alias: sg_user_eventtype }
```

Finally, you must update the configuration of the CalendarBundle so that it will use your form type instead of the default one.

``` yaml
# app/config/config.yml

sg_calendar:
    # ...
    form:
        event_name: sg_user_eventtype
        event_type: sg_user_eventtype
```

