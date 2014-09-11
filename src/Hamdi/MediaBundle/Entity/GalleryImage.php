<?php


namespace Hamdi\MediaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="gallery_image")
 */
class GalleryImage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var text
     * @ORM\Column(type="text")
     */
    private $description;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $largeur;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $longueur;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $url_img;
 
    /**
     * @ORM\ManyToMany(targetEntity="Hamdi\MediaBundle\Entity\Images")
     * @ORM\JoinTable(name="media_images_gallery",
     *      joinColumns={@ORM\JoinColumn(name="gallery_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="img_id", referencedColumnName="id")}
     * )
     */
    protected $images;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Gallery_image
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
     * Set description
     *
     * @param string $description
     * @return Gallery_image
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
     * Add images
     *
     * @param \Hamdi\MediaBundle\Entity\Images $images
     * @return Gallery_image
     */
    public function addImage(\Hamdi\MediaBundle\Entity\Images $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Hamdi\MediaBundle\Entity\Images $images
     */
    public function removeImage(\Hamdi\MediaBundle\Entity\Images $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set largeur
     *
     * @param integer $largeur
     * @return Gallery_image
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
    
        return $this;
    }

    /**
     * Get largeur
     *
     * @return integer 
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     * Set longueur
     *
     * @param integer $longueur
     * @return Gallery_image
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;
    
        return $this;
    }

    /**
     * Get longueur
     *
     * @return integer 
     */
    public function getLongueur()
    {
        return $this->longueur;
    }

    /**
     * Set url_img
     *
     * @param string $urlImg
     * @return Gallery_image
     */
    public function setUrlImg($urlImg)
    {
        $this->url_img = $urlImg;
    
        return $this;
    }

    /**
     * Get url_img
     *
     * @return string 
     */
    public function getUrlImg()
    {
        return $this->url_img;
    }
}