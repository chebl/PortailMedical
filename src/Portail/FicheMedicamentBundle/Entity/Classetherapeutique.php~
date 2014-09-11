<?php

namespace Portail\FicheMedicamentBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity()
 * @ORM\Table(name="ClasseTherapeutique")
 */

class Classetherapeutique
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
  private $nom;
/**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
  
  private $description;
   /**
* @ORM\OneToMany(targetEntity="Portail\FicheMedicamentBundle\Entity\Classetherapeutique",
mappedBy="classetherapeutique")
    
    */
 private $medicaments;
    

    
  

  

    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->medicaments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     * @return Classetherapeutique
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
     * Set description
     *
     * @param string $description
     * @return Classetherapeutique
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

    /**
     * Add medicaments
     *
     * @param \Portail\FicheMedicamentBundle\Entity\Classetherapeutique $medicaments
     * @return Classetherapeutique
     */
    public function addMedicament(\Portail\FicheMedicamentBundle\Entity\Classetherapeutique $medicaments)
    {
        $this->medicaments[] = $medicaments;
    
        return $this;
    }

    /**
     * Remove medicaments
     *
     * @param \Portail\FicheMedicamentBundle\Entity\Classetherapeutique $medicaments
     */
    public function removeMedicament(\Portail\FicheMedicamentBundle\Entity\Classetherapeutique $medicaments)
    {
        $this->medicaments->removeElement($medicaments);
    }

    /**
     * Get medicaments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedicaments()
    {
        return $this->medicaments;
    }
    
 public function __toString()
    {
      return $this->getNom();
    }

}