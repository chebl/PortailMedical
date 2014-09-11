<?php

namespace Portail\EtablissementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieEtab
 
 * @ORM\Entity
 */
class CategorieEtab
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
     *
     * @ORM\OneToMany(targetEntity="Portail\EtablissementBundle\Entity\Etablissement",mappedBy="categorie")
     */
    private $etablissements;
    
    
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
     * @return CategorieEtab
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etablissements = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add etablissements
     *
     * @param \Portail\EtablissementBundle\Entity\Etablissement $etablissements
     * @return CategorieEtab
     */
    public function addEtablissement(\Portail\EtablissementBundle\Entity\Etablissement $etablissements)
    {
        $this->etablissements[] = $etablissements;
    
        return $this;
    }

    /**
     * Remove etablissements
     *
     * @param \Portail\EtablissementBundle\Entity\Etablissement $etablissements
     */
    public function removeEtablissement(\Portail\EtablissementBundle\Entity\Etablissement $etablissements)
    {
        $this->etablissements->removeElement($etablissements);
    }

    /**
     * Get etablissements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEtablissements()
    {
        return $this->etablissements;
    }
      public function __toString()
    {
      return $this->getNom();
    }
}