<?php

namespace Portail\FrontBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="Portail\FrontBundle\Entity\FicheMaladieRepository")
 * @ORM\Table(name="FicheMaladie")
 */

class FicheMaladie
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
  private $designation;
/**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
  
  private $description;
  /**
     * @var string
     *
     * @ORM\Column(name="extrait", type="text")
     */
private $extrait;

        
/**
     * @var string
     *
     * @ORM\Column(name="symptomes", type="text",nullable=true)
     */
  private $symptomes;
/**
     * @var string
     *
     * @ORM\Column(name="causes", type="text",nullable=true)
     */
  private $causes;
/**
     * @var text
     *
     * @ORM\Column(name="prevention", type="text",nullable=true)
     */
  
private $prevention;
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
     * @var integer
     *
     * @ORM\Column(name="nbvue", type="integer",nullable=true)
     */
    private $nbvue;
/**
     *
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User",inversedBy="fiches")
     */
    private $auteur;

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
     *
     * @ORM\ManyToOne(targetEntity="Portail\BlogUserBundle\Entity\SousCategorie",inversedBy="sousfiches")
     */
    private $souscategorie;

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
     * @return FicheMaladie
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
     * Set description
     *
     * @param string $description
     * @return FicheMaladie
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
     * Set symptomes
     *
     * @param string $symptomes
     * @return FicheMaladie
     */
    public function setSymptomes($symtomes)
    {
        $this->symptomes = $symtomes;
    
        return $this;
    }

    /**
     * Get sypmtomes
     *
     * @return string 
     */
    public function getSymptomes()
    {
        return $this->symptomes;
    }

    /**
     * Set causes
     *
     * @param string $causes
     * @return FicheMaladie
     */
    public function setCauses($causes)
    {
        $this->causes = $causes;
    
        return $this;
    }

    /**
     * Get causes
     *
     * @return string 
     */
    public function getCauses()
    {
        return $this->causes;
    }

    /**
     * Set prevention
     *
     * @param string $prevention
     * @return FicheMaladie
     */
    public function setPrevention($prevention)
    {
        $this->prevention = $prevention;
    
        return $this;
    }

    /**
     * Get prevention
     *
     * @return string 
     */
    public function getPrevention()
    {
        return $this->prevention;
    }

    /**
     * Set datepublication
     *
     * @param \DateTime $datepublication
     * @return FicheMaladie
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
     * @return FicheMaladie
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
     * Set path
     *
     * @param string $path
     * @return FicheMaladie
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
    
    
    
     protected function getUploadDir($repertoire)
{
        return $repertoire;
}
 
public function getUploadRootDir($repertoire)
{
    return __DIR__.'/../../../../web/bundles/portailfront/images/'.$this->getUploadDir($repertoire);
}
 
public function getWebPath($repertoire)
{
    return null === $this->path ? null : $this->getUploadDir($repertoire).'/'.$this->path;
}
 
public function getAbsolutePath($repertoire)
{
    return null === $this->path ? null : $this->getUploadRootDir($repertoire).'/'.$this->path;
} 
   

public function upload($repertoire)
{
  // the file property can be empty if the field is not required
    if (null === $this->file) {
        return;
    }

    // we use the original file name here but you should
    // sanitize it at least to avoid any security issues

    // move takes the target directory and then the target filename to move to
    $this->file->move($this->getUploadRootDir($repertoire), $this->file->getClientOriginalName());

    // set the path property to the filename where you'ved saved the file
    $this->path = $this->file->getClientOriginalName();

    // clean up the file property as you won't need it anymore
    $this->file = null;
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
     * Set souscategorie
     *
     * @param \Portail\BlogUserBundle\Entity\SousCategorie $souscategorie
     * @return FicheMaladie
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return FicheMaladie
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
     * Set extrait
     *
     * @param string $extrait
     * @return FicheMaladie
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
     * Set nbvue
     *
     * @param integer $nbvue
     * @return FicheMaladie
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