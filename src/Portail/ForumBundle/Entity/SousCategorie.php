<?php
namespace Portail\ForumBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity()
 * @ORM\Table(name="SousCategorieforum")
 */
class SousCategorie {
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
* @ORM\OneToMany(targetEntity="Portail\ForumBundle\Entity\Question",
mappedBy="souscategorie",cascade={"remove"})
*/
 private $questions;
   /**
* @ORM\OneToMany(targetEntity="Portail\ForumBundle\Entity\Reponse",
mappedBy="souscategorie",cascade={"remove"})
*/
 private $reponses;
 /**
     * @var User $membre
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User")
     */
    private $membre;
 /**
     * @var Categorie $categorie
     * @ORM\ManyToOne(targetEntity="Portail\ForumBundle\Entity\Categorie")
     */
    
    private $categorie;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set designation
     *
     * @param string $designation
     * @return SousCategorie
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
     * Add questions
     *
     * @param \Portail\ForumBundle\Entity\Question $questions
     * @return SousCategorie
     */
    public function addQuestion(\Portail\ForumBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;
    
        return $this;
    }

    /**
     * Remove questions
     *
     * @param \Portail\ForumBundle\Entity\Question $questions
     */
    public function removeQuestion(\Portail\ForumBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set membre
     *
     * @param \Portail\FrontBundle\Entity\User $membre
     * @return SousCategorie
     */
    public function setMembre(\Portail\FrontBundle\Entity\User $membre = null)
    {
        $this->membre = $membre;
    
        return $this;
    }

    /**
     * Get membre
     *
     * @return \Portail\FrontBundle\Entity\User 
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * Set categorie
     *
     * @param \Portail\ForumBundle\Entity\Categorie $categorie
     * @return SousCategorie
     */
    public function setCategorie(\Portail\ForumBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Portail\ForumBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
     public function __toString()
    {
        return (string) $this->getDesignation();
    }

    /**
     * Add reponses
     *
     * @param \Portail\ForumBundle\Entity\Reponse $reponses
     * @return SousCategorie
     */
    public function addReponse(\Portail\ForumBundle\Entity\Reponse $reponses)
    {
        $this->reponses[] = $reponses;
    
        return $this;
    }

    /**
     * Remove reponses
     *
     * @param \Portail\ForumBundle\Entity\Reponse $reponses
     */
    public function removeReponse(\Portail\ForumBundle\Entity\Reponse $reponses)
    {
        $this->reponses->removeElement($reponses);
    }

    /**
     * Get reponses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReponses()
    {
        return $this->reponses;
    }
}