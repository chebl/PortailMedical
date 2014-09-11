<?php

namespace Portail\BlogUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousCategorie
 
 * @ORM\Entity
 */
class SousCategorie
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
     * @var datetime
     *
     * @ORM\Column(name="DatePublication", type="datetime")
     */
    private $datepublication;
/**
     * @var Categorie $categorie
     *
     * @ORM\ManyToOne(targetEntity="Portail\BlogUserBundle\Entity\Categorie")
     */
    private $categorie;
    
     /**
* @ORM\OneToMany(targetEntity="Portail\FrontBundle\Entity\FicheMaladie",
mappedBy="souscategorie")
*/
    private $sousfiches;
/**
* @ORM\OneToMany(targetEntity="Portail\FicheMedicamentBundle\Entity\FicheMedicament",
mappedBy="souscategorie")
*/
    private $medicaments;
/**
* @ORM\OneToMany(targetEntity="Hamdi\BlogBundle\Entity\Blog",
mappedBy="souscategorie")
*/
    private $blogs;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sousfiches = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return SousCategorie
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
     * Set datepublication
     *
     * @param \DateTime $datepublication
     * @return SousCategorie
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

    /**
     * Set categorie
     *
     * @param \Portail\BlogUserBundle\Entity\Categorie $categorie
     * @return SousCategorie
     */
    public function setCategorie(\Portail\BlogUserBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Portail\BlogUserBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Add sousfiches
     *
     * @param \Portail\FrontBundle\Entity\FicheMaladie $sousfiches
     * @return SousCategorie
     */
    public function addSousfiche(\Portail\FrontBundle\Entity\FicheMaladie $sousfiches)
    {
        $this->sousfiches[] = $sousfiches;
    
        return $this;
    }

    /**
     * Remove sousfiches
     *
     * @param \Portail\FrontBundle\Entity\FicheMaladie $sousfiches
     */
    public function removeSousfiche(\Portail\FrontBundle\Entity\FicheMaladie $sousfiches)
    {
        $this->sousfiches->removeElement($sousfiches);
    }

    /**
     * Get sousfiches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSousfiches()
    {
        return $this->sousfiches;
    }

    /**
     * Add medicaments
     *
     * @param \Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments
     * @return SousCategorie
     */
    public function addMedicament(\Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments)
    {
        $this->medicaments[] = $medicaments;
    
        return $this;
    }

    /**
     * Remove medicaments
     *
     * @param \Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments
     */
    public function removeMedicament(\Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments)
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
    public function __toString() {
        
        return $this->getNom();
        
    }

    /**
     * Add blogs
     *
     * @param \Hamdi\BlogBundle\Entity\Blog $blogs
     * @return SousCategorie
     */
    public function addBlog(\Hamdi\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs[] = $blogs;
    
        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \Hamdi\BlogBundle\Entity\Blog $blogs
     */
    public function removeBlog(\Hamdi\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs()
    {
        return $this->blogs;
    }
}