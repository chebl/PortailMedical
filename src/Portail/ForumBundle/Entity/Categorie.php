<?php

namespace Portail\ForumBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity()
 * @ORM\Table(name="Categorieforum")
 */
class Categorie {
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
     * @var datetime
     *
     * @ORM\Column(name="datepublication", type="datetime")
     */
  private $datepublication;
   
   

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
     * @return Categorie
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
     * Set datepublication
     *
     * @param \DateTime $datepublication
     * @return Categorie
     */
    public function setDatepublication($datepublication)
    {
        $this->datepublication = $datepublication;
    
        return $this;
    }

    /**
     * Get datepublication
     *
     * @return \DateTime 
     */
    public function getDatepublication()
    {
        return $this->datepublication;
    }
  public function __toString()
    {
        return (string) $this->getDesignation();
    }
}