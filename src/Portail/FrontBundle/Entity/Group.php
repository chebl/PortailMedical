<?php

namespace Portail\FrontBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;

    
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    
}