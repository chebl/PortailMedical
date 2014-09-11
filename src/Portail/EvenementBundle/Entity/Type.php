<?php

namespace Portail\EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeEvt
 
 * @ORM\Entity
 * @ORM\Table(name="typeevenement")
 */
class Type
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
     /**
* @ORM\OneToMany(targetEntity="Portail\EvenementBundle\Entity\Evenement",
mappedBy="type")
    
    */
 private $evenements;

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
     * Set nom
     *
     * @param string $nom
     * @return Type
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
     public function __toString()
    {
      return $this->getNom();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add evenements
     *
     * @param \Portail\EvenementBundle\Entity\Evenement $evenements
     * @return Type
     */
    public function addEvenement(\Portail\EvenementBundle\Entity\Evenement $evenements)
    {
        $this->evenements[] = $evenements;
    
        return $this;
    }

    /**
     * Remove evenements
     *
     * @param \Portail\EvenementBundle\Entity\Evenement $evenements
     */
    public function removeEvenement(\Portail\EvenementBundle\Entity\Evenement $evenements)
    {
        $this->evenements->removeElement($evenements);
    }

    /**
     * Get evenements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvenements()
    {
        return $this->evenements;
    }
}