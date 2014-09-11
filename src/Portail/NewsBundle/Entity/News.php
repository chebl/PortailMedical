<?php
namespace Portail\NewsBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Portail\NewsBundle\Entity\NewsRepository")
 * @ORM\Table(name="News")
 */
class News {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
     /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50)
     */
    private $titre;
     /**
     * @var string
     *
     * @ORM\Column(name="extrait", type="string", length=50)
     */
    private $extrait;
    
     /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;
 /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=50)
     */
    private $logo;
 /**
     * @var date
     *
     * @ORM\Column(name="datepublication", type="datetime")
     */
    private $datepublication;
    
    
    
   
             /**
* @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User",
inversedBy="articles")
*/
 private $auteur;
    
    
    
        
    
    
    

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
     * Set titre
     *
     * @param string $titre
     * @return News
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
     * Set contenu
     *
     * @param string $contenu
     * @return News
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    
        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

   
    /**
     * Set datepublication
     *
     * @param \DateTime $datepublication
     * @return News
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
     * Set auteur
     *
     * @param \Portail\FrontBundle\Entity\User $auteur
     * @return News
     */
    public function setAuteur(\Portail\FrontBundle\Entity\User $auteur = null)
    {
        $this->auteur = $auteur;
    
        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Portail\FrontBundle\Entity\User 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set extrait
     *
     * @param string $extrait
     * @return News
     */
    public function setExtrait($extrait)
    {
        $this->extrait = $extrait;
    
        return $this;
    }

    /**
     * Get extrait
     *
     * @return string 
     */
    public function getExtrait()
    {
        return $this->extrait;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return News
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }
}