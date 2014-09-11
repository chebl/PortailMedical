<?php

namespace Portail\ForumBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity()
 * @ORM\Table(name="Reponse")
 */
class Reponse {

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
     *
     * @ORM\ManyToOne(targetEntity="Portail\ForumBundle\Entity\Question",inversedBy="reponses")
     */
    private $question;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Portail\ForumBundle\Entity\SousCategorie",inversedBy="reponses")
     */
    private $souscategorie;
    /**
     *@var User $membre
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User")
     */
    private $membre;
    

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
     * @return Reponse
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
     * @return Reponse
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
     * Set question
     *
     * @param \Portail\ForumBundle\Entity\Question $question
     * @return Reponse
     */
    public function setQuestion(\Portail\ForumBundle\Entity\Question $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Portail\ForumBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set membre
     *
     * @param \Portail\FrontBundle\Entity\User $membre
     * @return Reponse
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
     * @return Reponse
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
     * Set souscategorie
     *
     * @param \Portail\ForumBundle\Entity\SousCategorie $souscategorie
     * @return Reponse
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
}