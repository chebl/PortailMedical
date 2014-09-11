<?php
namespace Portail\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BladeTester\CalendarBundle\Entity\Event as BaseEvent;


/**
 * @ORM\Entity(repositoryClass="Portail\CalendarBundle\Repository\EventRepository")
 * @ORM\Table(name="events")
 */
class Event extends BaseEvent {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

/**
       * @var User $user
     *
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User")
     */
    
       private $user;
    
    
    public function getId() {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \Portail\FrontBundle\Entity\User $user
     * @return Event
     */
    public function setUser(\Portail\FrontBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Portail\FrontBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}