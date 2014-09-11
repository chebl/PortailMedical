<?php

namespace Hamdi\PartenaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Partenaire
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Hamdi\PartenaireBundle\Entity\PartenaireRepository")
 */
class Partenaire
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
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string",length=255,nullable=true)
     */
     private $path;
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    protected function getUploadDir($repertoire)
{
        return $repertoire;
}
 
public function getUploadRootDir($repertoire)
{
    return __DIR__.'/../../../../web/bundles/hamdimedia/gallery/'.$this->getUploadDir($repertoire);
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

    
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Partenaire
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
     * Set site
     *
     * @param string $site
     * @return Partenaire
     */
    public function setSite($site)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    

    

    /**
     * Set path
     *
     * @param string $path
     * @return Partenaire
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
}