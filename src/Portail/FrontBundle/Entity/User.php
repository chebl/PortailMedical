<?php 
namespace Portail\FrontBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="Utilisateur")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     
     */
    private $nom;
/**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;
    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=20)
     */
    private $telephone;
    /**
     * @var date
     *
     * @ORM\Column(name="datenaissance", type="date")
     */
    private $datenaissance;
    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string",length=20)
     */
    private $sexe;
    /**
     * @var Etablissement $etablissement
     *
     * @ORM\ManyToOne(targetEntity="Portail\EtablissementBundle\Entity\Etablissement")
     */
    private $etablissement;
    
    
    
     /**
     * @var Profession $profession
     *
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\Profession")
     */
    
    private $profession;
    
      /**
     * @var Specialite $specialite
     *
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\Specialite")
     */
     private $specialite;
      /**
     * @var double
     *
     * @ORM\Column(name="latitude", type="float",nullable=true)
     */
     private $latitude;
     /**
     * @var double
     *
     * @ORM\Column(name="longitude", type="float",nullable=true)
     */
     private $longitude;
       /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string",length=100,nullable=true)
     */
     private $logo;
     
        /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
     
    /**
* @ORM\OneToMany(targetEntity="Portail\NewsBundle\Entity\News",
mappedBy="auteur")
*/
 private $articles;
    /**
* @ORM\OneToMany(targetEntity="Hamdi\ContactBundle\Entity\Contact",
mappedBy="destinataire")
*/
 private $emails;
     /**
* @ORM\OneToMany(targetEntity="Hamdi\ContactBundle\Entity\Contact",
mappedBy="expediteur")
*/
 private $emailsexpediteur;
  /**
* @ORM\OneToMany(targetEntity="Portail\FrontBundle\Entity\FicheMaladie",
mappedBy="auteur")
*/
private $fiches;  
 /**
*@var Blog $blogs
* @ORM\OneToMany(targetEntity="Hamdi\BlogBundle\Entity\Blog",
mappedBy="auteur")
*/
private $blogs;
/**
* @ORM\OneToMany(targetEntity="Portail\FicheMedicamentBundle\Entity\FicheMedicament",
mappedBy="auteur")
*/

private $medicaments;
 
 public function __construct()
    {
        parent::__construct();
        // your own logic
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
    return null === $this->logo ? null : $this->getUploadDir($repertoire).'/'.$this->logo;
}
 
public function getAbsolutePath($repertoire)
{
    return null === $this->logo ? null : $this->getUploadRootDir($repertoire).'/'.$this->logo;
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
    $this->logo = $this->file->getClientOriginalName();

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
     * Set nom
     *
     * @param string $nom
     * @return User
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
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
     
    

    /**
     * Set pays
     *
     * @param string $pays
     * @return User
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    
        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

   
    /**
     * Set datenaissance
     *
     * @param \DateTime $datenaissance
     * @return User
     */
    public function setDatenaissance($datenaissance)
    {
        $this->datenaissance = $datenaissance;
    
        return $this;
    }

    /**
     * Get datenaissance
     *
     * @return \DateTime 
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    
        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set inewsletter
     *
     * @param boolean $inewsletter
     * @return User
     */
    public function setInewsletter($inewsletter)
    {
        $this->inewsletter = $inewsletter;
    
        return $this;
    }

    /**
     * Get inewsletter
     *
     * @return boolean 
     */
    public function getInewsletter()
    {
        return $this->inewsletter;
    }

  

    /**
     * Add articles
     *
     * @param \Portail\NewsBundle\Entity\News $articles
     * @return User
     */
    public function addArticle(\Portail\NewsBundle\Entity\News $articles)
    {
        $this->articles[] = $articles;
    
        return $this;
    }

    /**
     * Remove articles
     *
     * @param \Portail\NewsBundle\Entity\News $articles
     */
    public function removeArticle(\Portail\NewsBundle\Entity\News $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set profession
     *
     * @param string $profession
     * @return User
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;
    
        return $this;
    }

    /**
     * Get profession
     *
     * @return string 
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set specialite
     *
     * @param string $specialite
     * @return User
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
    
        return $this;
    }

    /**
     * Get specialite
     *
     * @return string 
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    
        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return User
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param double $longitude
     * @return User
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return double
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    

    /**
     * Add emails
     *
     * @param \Hamdi\ContactBundle\Entity\Contact $emails
     * @return User
     */
    public function addEmail(\Hamdi\ContactBundle\Entity\Contact $emails)
    {
        $this->emails[] = $emails;
    
        return $this;
    }

    /**
     * Remove emails
     *
     * @param \Hamdi\ContactBundle\Entity\Contact $emails
     */
    public function removeEmail(\Hamdi\ContactBundle\Entity\Contact $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add emailsexpediteur
     *
     * @param \Hamdi\ContactBundle\Entity\Contact $emailsexpediteur
     * @return User
     */
    public function addEmailsexpediteur(\Hamdi\ContactBundle\Entity\Contact $emailsexpediteur)
    {
        $this->emailsexpediteur[] = $emailsexpediteur;
    
        return $this;
    }

    /**
     * Remove emailsexpediteur
     *
     * @param \Hamdi\ContactBundle\Entity\Contact $emailsexpediteur
     */
    public function removeEmailsexpediteur(\Hamdi\ContactBundle\Entity\Contact $emailsexpediteur)
    {
        $this->emailsexpediteur->removeElement($emailsexpediteur);
    }

    /**
     * Get emailsexpediteur
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmailsexpediteur()
    {
        return $this->emailsexpediteur;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return User
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

    /**
     * Add fiches
     *
     * @param \Portail\FrontBundle\Entity\FicheMaladie $fiches
     * @return User
     */
    public function addFiche(\Portail\FrontBundle\Entity\FicheMaladie $fiches)
    {
        $this->fiches[] = $fiches;
    
        return $this;
    }

    /**
     * Remove fiches
     *
     * @param \Portail\FrontBundle\Entity\FicheMaladie $fiches
     */
    public function removeFiche(\Portail\FrontBundle\Entity\FicheMaladie $fiches)
    {
        $this->fiches->removeElement($fiches);
    }

    /**
     * Get fiches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiches()
    {
        return $this->fiches;
    }

    /**
     * Add blogs
     *
     * @param \Hamdi\BlogBundle\Entity\Blog $blogs
     * @return User
     */
    public function addBlog(\Hamdi\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs[] = $blogs;
    
        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \Hamdi\BlogBundle\Entity\Blog $blogs
     */
    public function removeBlog(\Hamdi\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs()
    {
        return $this->blogs;
    }

   


    /**
     * Set etablissement
     *
     * @param \Portail\EtablissementBundle\Entity\Etablissement $etablissement
     * @return User
     */
    public function setEtablissement(\Portail\EtablissementBundle\Entity\Etablissement $etablissement = null)
    {
        $this->etablissement = $etablissement;
    
        return $this;
    }

    /**
     * Get etablissement
     *
     * @return \Portail\EtablissementBundle\Entity\Etablissement 
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Add medicaments
     *
     * @param \Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments
     * @return User
     */
    public function addMedicament(\Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments)
    {
        $this->medicaments[] = $medicaments;
    
        return $this;
    }

    /**
     * Remove medicaments
     *
     * @param \Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments
     */
    public function removeMedicament(\Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments)
    {
        $this->medicaments->removeElement($medicaments);
    }

    /**
     * Get medicaments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedicaments()
    {
        return $this->medicaments;
    }
   
}