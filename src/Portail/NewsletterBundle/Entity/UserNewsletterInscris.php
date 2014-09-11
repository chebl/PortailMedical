<?php

namespace Portail\NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserNewsletterInscris
 
 * @ORM\Entity(repositoryClass="Portail\NewsletterBundle\Entity\UserNewsletterInscrisRepository")
 */
class UserNewsletterInscris
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
   /**
     * @var boolean
     *
     * @ORM\Column(name="Estconfirm", type="boolean")
     */
    private $Estconfirm;
   
 

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
     * Set email
     *
     * @param string $email
     * @return UserNewsletterInscris
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
     * Set Estconfirm
     *
     * @param boolean $estconfirm
     * @return UserNewsletterInscris
     */
    public function setEstconfirm($estconfirm)
    {
        $this->Estconfirm = $estconfirm;
    
        return $this;
    }

    /**
     * Get Estconfirm
     *
     * @return boolean 
     */
    public function getEstconfirm()
    {
        return $this->Estconfirm;
    }
}