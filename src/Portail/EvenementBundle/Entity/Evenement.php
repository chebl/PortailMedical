<?php

namespace Portail\EvenementBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity()
 * @ORM\Table(name="evenement")
 
 */

class Evenement
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var datetime
     *
     * @ORM\Column(name="datedebut", type="datetime")
     */
  private $datedebut;
  /**
     * @var datetime
     *
     * @ORM\Column(name="datefin", type="datetime")
     */
  private $datefin;
/**
     * @var text
     *
     * @ORM\Column(name="lieu", type="string",length=255)
     */
  private $lieu;
  /**
     * @var text
     *
     * @ORM\Column(name="titre", type="string",length=100)
     */
  
    private $titre;
      /**
     * @var double
     *
     * @ORM\Column(name="latitude", type="float",nullable=true)
     */
    
    
    
     private $latitude;
    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
     private $description;
     /**
     * @var double
     *
     * @ORM\Column(name="longitude", type="float",nullable=true)
     */
     private $longitude;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Portail\EvenementBundle\Entity\Categorie",inversedBy="evenements")
     */
    private $categorie;
    
/**
     * @var text
     *
     * @ORM\Column(name="organisateur", type="string",length=100)
     */
  
    private $organisateur;
   /**
     *
     * @ORM\ManyToOne(targetEntity="Portail\EvenementBundle\Entity\Type",inversedBy="evenements")
     */
    private $type;

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
     * Set datedebut
     *
     * @param \DateTime $datedebut
     * @return Evenement
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;
    
        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime 
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     * @return Evenement
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;
    
        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime 
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     * @return Evenement
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    
        return $this;
    }

    /**
     * Get lieu
     *
     * @return string 
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Evenement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set organisateur
     *
     * @param string $organisateur
     * @return Evenement
     */
    public function setOrganisateur($organisateur)
    {
        $this->organisateur = $organisateur;
    
        return $this;
    }

    /**
     * Get organisateur
     *
     * @return string 
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * Set categorie
     *
     * @param \Portail\EvenementBundle\Entity\Categorie $categorie
     * @return Evenement
     */
    public function setCategorie(\Portail\EvenementBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Portail\EvenementBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set type
     *
     * @param \Portail\EvenementBundle\Entity\Type $type
     * @return Evenement
     */
    public function setType(\Portail\EvenementBundle\Entity\Type $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Portail\EvenementBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Evenement
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Evenement
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Evenement
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}