<?php

namespace Portail\ForumBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity()
 * @ORM\Table(name="Question")
 */

class Question {
    
      /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
      /**
     * @var text
     *
     * @ORM\Column(name="message", type="text")
     */
  private $message;
    
     /**
     * @var datetime
     *
     * @ORM\Column(name="datepublication", type="datetime")
     */
  private $datepublication;
   /**
     * @var int
     *
     * @ORM\Column(name="nbrsignal", type="integer",nullable=true)
     */
  private $nbrsignal;
   /**
     * @var int
     *
     * @ORM\Column(name="nbvue", type="integer",nullable=true)
     */
  private $nbvue;
  
/**
* @ORM\OneToMany(targetEntity="Portail\ForumBundle\Entity\Reponse",
mappedBy="question",cascade={"remove"})
*/
 private $reponses;

  /**
     *
     * @ORM\ManyToOne(targetEntity="Portail\ForumBundle\Entity\SousCategorie",inversedBy="questions")
     */
    private $souscategorie;
 /** 
     *@var User $membre
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User")
     */
    private $membre;

    
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reponses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set message
     *
     * @param string $message
     * @return Question
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set datepublication
     *
     * @param \DateTime $datepublication
     * @return Question
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
     * Add reponses
     *
     * @param \Portail\ForumBundle\Entity\Reponse $reponses
     * @return Question
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

    /**
     * Set souscategorie
     *
     * @param \Portail\ForumBundle\Entity\SousCategorie $souscategorie
     * @return Question
     */
    public function setSouscategorie(\Portail\ForumBundle\Entity\SousCategorie $souscategorie = null)
    {
        $this->souscategorie = $souscategorie;
    
        return $this;
    }

    /**
     * Get souscategorie
     *
     * @return \Portail\ForumBundle\Entity\SousCategorie 
     */
    public function getSouscategorie()
    {
        return $this->souscategorie;
    }

    /**
     * Set membre
     *
     * @param \Portail\FrontBundle\Entity\User $membre
     * @return Question
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
     * Set nbrsignal
     *
     * @param integer $nbrsignal
     * @return Question
     */
    public function setNbrsignal($nbrsignal)
    {
        $this->nbrsignal = $nbrsignal;
    
        return $this;
    }

    /**
     * Get nbrsignal
     *
     * @return integer 
     */
    public function getNbrsignal()
    {
        return $this->nbrsignal;
    }

    /**
     * Set nbvue
     *
     * @param integer $nbvue
     * @return Question
     */
    public function setNbvue($nbvue)
    {
        $this->nbvue = $nbvue;
    
        return $this;
    }

    /**
     * Get nbvue
     *
     * @return integer 
     */
    public function getNbvue()
    {
        return $this->nbvue;
    }
}