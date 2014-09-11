<?php

namespace Hamdi\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MaxLength;
/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hamdi\ContactBundle\Entity\ContactRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Contact
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
     * @ORM\Column(name="sujet", type="string", length=255)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var datetime
     *
     * @ORM\Column(name="dateEnvoi", type="datetime")
     */
   
    private $dateenvoi;
    
    /**
* @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User",
inversedBy="emails")
*/
     private $destinataire;
    /**
* @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User",
inversedBy="emailsexpediteur")
*/
       private $expediteur;

    /**
     * @var boolean
     *
     * @ORM\Column(name="msg_vue", type="boolean")
     */
    private $msg_vue;

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
     * Set name
     *
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    

    /**
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Contact
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

    
    public function __construct() {
        $this->msg_vue = 0;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->created_at =  new \DateTime('now');
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank(array('message' => 'Champ vide !!!')));
        
        $metadata->addPropertyConstraint('email', new NotBlank(array('message' => 'Champ vide !!!')));
        $metadata->addPropertyConstraint('email', new Email(array(
        'message' => 'email invalide')));

        $metadata->addPropertyConstraint('message', new NotBlank(array('message' => 'Champ vide !!!')));
        $metadata->addPropertyConstraint('message', new MaxLength(50));

    }

    /**
     * Set sujet
     *
     * @param string $sujet
     * @return Contact
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
    
        return $this;
    }

    /**
     * Get sujet
     *
     * @return string 
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set msg_vue
     *
     * @param boolean $msgVue
     * @return Contact
     */
    public function setMsgVue($msgVue)
    {
        $this->msg_vue = $msgVue;
    
        return $this;
    }

    /**
     * Get msg_vue
     *
     * @return boolean 
     */
    public function getMsgVue()
    {
        return $this->msg_vue;
    }

    /**
     * Set dateenvoi
     *
     * @param \DateTime $dateenvoi
     * @return Contact
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
     * Set destinataire
     *
     * @param \Portail\FrontBundle\Entity\User $destinataire
     * @return Contact
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
     * @return Contact
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
}