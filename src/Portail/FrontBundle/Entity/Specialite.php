<?php

namespace Portail\FrontBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Specialite")
 */

class Specialite
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string",length=255)
     */
  private $designation;
 /**
     * @var Profession $profession
     *
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\Profession")
     */
  private $profession;
  

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
     * Set designation
     *
     * @param string $designation
     * @return Specialite
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    
        return $this;
    }

    /**
     * Get designation
     *
     * @return string 
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set profession
     *
     * @param \Portail\FrontBundle\Entity\Profession $profession
     * @return Specialite
     */
    public function setProfession(\Portail\FrontBundle\Entity\Profession $profession = null)
    {
        $this->profession = $profession;
    
        return $this;
    }

    /**
     * Get profession
     *
     * @return \Portail\FrontBundle\Entity\Profession 
     */
    public function getProfession()
    {
        return $this->profession;
    }
    
      public function __toString()
    {
      return $this->getDesignation();
    }
}