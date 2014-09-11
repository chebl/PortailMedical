<?php

namespace Portail\FicheMedicamentBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity()
 * @ORM\Table(name="FicheMedicament")
 * @ORM\HasLifecycleCallbacks
 */

class FicheMedicament
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
     * @var text
     *
     * @ORM\Column(name="prescription", type="text")
     */
  
  private $prescription;
  /**
     * @var text
     *
     * @ORM\Column(name="presentation", type="text")
     */
private $presentation;

        
/**
     * @var text
     *
     * @ORM\Column(name="contrindication", type="text",nullable=true)
     */
  private $contreindication;
/**
     * @var text
     *
     * @ORM\Column(name="posologie", type="text",nullable=true)
     */
  private $posologie;
/**
     * @var text
     *
     * @ORM\Column(name="effetindesirable", type="text",nullable=true)
     */
  
private $effetindesirable;
 /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;
      /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;


/**
     * @var \DateTime
     *
     * @ORM\Column(name="datepublication", type="datetime")
     */
    private $datepublication;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;
	/**
     * @var integer
     *
     * @ORM\Column(name="nbvue", type="integer",nullable=true)
     */
    private $nbvue;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Portail\EtablissementBundle\Entity\Etablissement",inversedBy="medicaments")
     */
    private $laboratoire;
      /**
     *
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User",inversedBy="medicaments")
     */
    private $auteur;
/**
     *
     * @ORM\ManyToOne(targetEntity="Portail\BlogUserBundle\Entity\SousCategorie",inversedBy="medicaments")
     */
    private $souscategorie;

    
/**
     *
     * @ORM\ManyToOne(targetEntity="Portail\FicheMedicamentBundle\Entity\Classetherapeutique",inversedBy="medicaments")
     */
    private $classetherapeutique;
    

    
    
   
    
    
     protected function getUploadDir()
{
        return 'medicaments';
}
 
public function getUploadRootDir()
{
    return __DIR__.'/../../../../web/bundles/portailfront/images/'.$this->getUploadDir();
}
 
public function getWebPath()
{
    return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
}
 
public function getAbsolutePath()
{
    return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
} 
   
/**
 * 
 * @ORM\PrePersist()
 * @ORM\PreUpdate()
 */
public function upload()
{
  // the file property can be empty if the field is not required
    if (null === $this->file) {
        return;
    }

    // we use the original file name here but you should
    // sanitize it at least to avoid any security issues

    // move takes the target directory and then the target filename to move to
    $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

    // set the path property to the filename where you'ved saved the file
    $this->path = $this->file->getClientOriginalName();

    // clean up the file property as you won't need it anymore
    $this->file = null;
$this->redimensionner_image($this->getUploadRootDir().'/'.$this->getPath(), 1024, 768);
               
    
}
 
public function redimensionner_image($fichier, $longueur,$largeur) {

    //VARIABLE D'ERREUR
    global $error;

    //TAILLE DE L'IMAGE ACTUELLE
    $taille = getimagesize($fichier);
	
	//SI LE FICHIER EXISTE
    if ($taille) {
    
        //SI JPG
        if ($taille['mime']=='image/jpeg' ) {
            //OUVERTURE DE L'IMAGE ORIGINALE
            $img_big = imagecreatefromjpeg($fichier); 
            $img_new = imagecreate($longueur, $largeur);
            
            //CREATION DE LA MINIATURE
            $img_petite = imagecreatetruecolor($longueur, $largeur) or $img_petite = imagecreate($longueur, $largeur);

			//COPIE DE L'IMAGE REDIMENSIONNEE
            imagecopyresized($img_petite,$img_big,0,0,0,0,$longueur,$largeur,$taille[0],$taille[1]);
            imagejpeg($img_petite,$fichier);

        }
        
        //SI PNG
        else if ($taille['mime']=='image/png' ) {
            //OUVERTURE DE L'IMAGE ORIGINALE
            $img_big = imagecreatefrompng($fichier); // On ouvre l'image d'origine
            $img_new = imagecreate($longueur, $largeur);
            
            //CREATION DE LA MINIATURE
            $img_petite = imagecreatetruecolor($longueur, $largeur) OR $img_petite = imagecreate($longueur, $largeur);

            //COPIE DE L'IMAGE REDIMENSIONNEE
            imagecopyresized($img_petite,$img_big,0,0,0,0,$longueur,$largeur,$taille[0],$taille[1]);
            imagepng($img_petite,$fichier);
 
        }
        // GIF
        else if ($taille['mime']=='image/gif' ) {
            //OUVERTURE DE L'IMAGE ORIGINALE
            $img_big = imagecreatefromgif($fichier); 
            $img_new = imagecreate($longueur, $largeur);
			
            //CREATION DE LA MINIATURE
            $img_petite = imagecreatetruecolor($longueur, $largeur) or $img_petite = imagecreate($longueur, $largeur);

            //COPIE DE L'IMAGE REDIMENSIONNEE
            imagecopyresized($img_petite,$img_big,0,0,0,0,$longueur,$largeur,$taille[0],$taille[1]);
            imagegif($img_petite,$fichier);

        }
		
    }
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
     * @return FicheMedicament
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
     * Set prescription
     *
     * @param string $prescription
     * @return FicheMedicament
     */
    public function setPrescription($prescription)
    {
        $this->prescription = $prescription;
    
        return $this;
    }

    /**
     * Get prescription
     *
     * @return string 
     */
    public function getPrescription()
    {
        return $this->prescription;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
     * @return FicheMedicament
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;
    
        return $this;
    }

    /**
     * Get presentation
     *
     * @return string 
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set contreindication
     *
     * @param string $contreindication
     * @return FicheMedicament
     */
    public function setContreindication($contreindication)
    {
        $this->contreindication = $contreindication;
    
        return $this;
    }

    /**
     * Get contreindication
     *
     * @return string 
     */
    public function getContreindication()
    {
        return $this->contreindication;
    }

    /**
     * Set posologie
     *
     * @param string $posologie
     * @return FicheMedicament
     */
    public function setPosologie($posologie)
    {
        $this->posologie = $posologie;
    
        return $this;
    }

    /**
     * Get posologie
     *
     * @return string 
     */
    public function getPosologie()
    {
        return $this->posologie;
    }

    /**
     * Set effetindesirable
     *
     * @param string $effetindesirable
     * @return FicheMedicament
     */
    public function setEffetindesirable($effetindesirable)
    {
        $this->effetindesirable = $effetindesirable;
    
        return $this;
    }

    /**
     * Get effetindesirable
     *
     * @return string 
     */
    public function getEffetindesirable()
    {
        return $this->effetindesirable;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return FicheMedicament
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set datepublication
     *
     * @param \DateTime $datepublication
     * @return FicheMedicament
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return FicheMedicament
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    
    /**
     * Set souscategorie
     *
     * @param \Portail\BlogUserBundle\Entity\SousCategorie $souscategorie
     * @return FicheMedicament
     */
    public function setSouscategorie(\Portail\BlogUserBundle\Entity\SousCategorie $souscategorie = null)
    {
        $this->souscategorie = $souscategorie;
    
        return $this;
    }

    /**
     * Get souscategorie
     *
     * @return \Portail\BlogUserBundle\Entity\SousCategorie 
     */
    public function getSouscategorie()
    {
        return $this->souscategorie;
    }

    /**
     * Set classetherapeutique
     *
     * @param \Portail\FicheMedicamentBundle\Entity\Classetherapeutique $classetherapeutique
     * @return FicheMedicament
     */
    public function setClassetherapeutique(\Portail\FicheMedicamentBundle\Entity\Classetherapeutique $classetherapeutique = null)
    {
        $this->classetherapeutique = $classetherapeutique;
    
        return $this;
    }

    /**
     * Get classetherapeutique
     *
     * @return \Portail\FicheMedicamentBundle\Entity\Classetherapeutique 
     */
    public function getClassetherapeutique()
    {
        return $this->classetherapeutique;
    }

   

    /**
     * Set laboratoire
     *
     * @param \Portail\EtablissementBundle\Entity\Etablissement $laboratoire
     * @return FicheMedicament
     */
    public function setLaboratoire(\Portail\EtablissementBundle\Entity\Etablissement $laboratoire = null)
    {
        $this->laboratoire = $laboratoire;
    
        return $this;
    }

    /**
     * Get laboratoire
     *
     * @return \Portail\EtablissementBundle\Entity\Etablissement 
     */
    public function getLaboratoire()
    {
        return $this->laboratoire;
    }

    /**
     * Set auteur
     *
     * @param \Portail\FrontBundle\Entity\User $auteur
     * @return FicheMedicament
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
     * Set nbvue
     *
     * @param integer $nbvue
     * @return FicheMedicament
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