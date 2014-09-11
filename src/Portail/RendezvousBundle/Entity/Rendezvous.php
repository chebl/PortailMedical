<?php
namespace Portail\RendezvousBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Rendezvous")
 */

class Rendezvous 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="daterendezvous", type="datetime",nullable=true)
     */
    
    private $daterendezvous;
    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnvoi", type="datetime")
     */
    private $dateenvoi;
  /**
     * @var string
     *
     * @ORM\Column(name="messageexpediteur", type="text",nullable=true)
     */
    private $messageexpediteur;
  
    /**
     * @var string
     *
     * @ORM\Column(name="messagedestinataire", type="text",nullable=true)
     */
    private $messagedestinataire;
  
    /**
     * @var boolean
     *
     * @ORM\Column(name="estfixe", type="boolean")
     */
    
    private $estfixe;
    /**
     * @var User $destinataire
     *
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User",inversedBy="rendezvous")
     */
    
     private $destinataire;
    /**
     * @var User $expediteur
     *
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User")
     */
    
       private $expediteur;
   
    
    

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
     * Set daterendezvous
     *
     * @param \DateTime $daterendezvous
     * @return Rendezvous
     */
    public function setDaterendezvous($daterendezvous)
    {
        $this->daterendezvous = $daterendezvous;
    
        return $this;
    }

    /**
     * Get daterendezvous
     *
     * @return \DateTime 
     */
    public function getDaterendezvous()
    {
        return $this->daterendezvous;
    }

   
    /**
     * Set destinataire
     *
     * @param \Portail\FrontBundle\Entity\User $destinataire
     * @return Rendezvous
     */
    public function setDestinataire(\Portail\FrontBundle\Entity\User $destinataire = null)
    {
        $this->destinataire = $destinataire;
    
        return $this;
    }

    /**
     * Get destinataire
     *
     * @return \Portail\FrontBundle\Entity\User 
     */
    public function getDestinataire()
    {
        return $this->destinataire;
    }

    /**
     * Set expediteur
     *
     * @param \Portail\FrontBundle\Entity\User $expediteur
     * @return Rendezvous
     */
    public function setExpediteur(\Portail\FrontBundle\Entity\User $expediteur = null)
    {
        $this->expediteur = $expediteur;
    
        return $this;
    }

    /**
     * Get expediteur
     *
     * @return \Portail\FrontBundle\Entity\User 
     */
    public function getExpediteur()
    {
        return $this->expediteur;
    }

    /**
     * Set dateenvoi
     *
     * @param \DateTime $dateenvoi
     * @return Rendezvous
     */
    public function setDateenvoi($dateenvoi)
    {
        $this->dateenvoi = $dateenvoi;
    
        return $this;
    }

    /**
     * Get dateenvoi
     *
     * @return \DateTime 
     */
    public function getDateenvoi()
    {
        return $this->dateenvoi;
    }

    /**
     * Set estfixe
     *
     * @param boolean $estfixe
     * @return Rendezvous
     */
    public function setEstfixe($estfixe)
    {
        $this->estfixe = $estfixe;
    
        return $this;
    }

    /**
     * Get estfixe
     *
     * @return boolean 
     */
    public function getEstfixe()
    {
        return $this->estfixe;
    }

    /**
     * Set messageexpediteur
     *
     * @param string $messageexpediteur
     * @return Rendezvous
     */
    public function setMessageexpediteur($messageexpediteur)
    {
        $this->messageexpediteur = $messageexpediteur;
    
        return $this;
    }

    /**
     * Get messageexpediteur
     *
     * @return string 
     */
    public function getMessageexpediteur()
    {
        return $this->messageexpediteur;
    }

    /**
     * Set messagedestinataire
     *
     * @param string $messagedestinataire
     * @return Rendezvous
     */
    public function setMessagedestinataire($messagedestinataire)
    {
        $this->messagedestinataire = $messagedestinataire;
    
        return $this;
    }

    /**
     * Get messagedestinataire
     *
     * @return string 
     */
    public function getMessagedestinataire()
    {
        return $this->messagedestinataire;
    }
}