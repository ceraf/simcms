<?php

namespace Sacprd\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sacprd\Core\BaseDBModel;

use Sacprd\Core\FileUploaderTrait;
use AppBundle\Service\FileUploader;



/**
 * @ORM\Entity(repositoryClass="Sacprd\PageBundle\Entity\Repository\CategoryRepository")
 * @ORM\Table(name="page_category")
 * @ORM\HasLifecycleCallbacks()
 */
class Category implements BaseDBModel
{
    use FileUploaderTrait;
    
    const LOCAL_PATH = 'images/page/category/';
    
	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
    
	/**
    * @ORM\column(type="integer", nullable=true, options={"unsigned":true, "default":0})
	*/    
    protected $site_id;
	
	/**
	* @ORM\column(type="string", length=100, unique=true)
	*/
	protected $title;
	
	/**
	* @ORM\column(type="string", length=200, unique=true)
	*/
	protected $url;
    
	/**
	* @ORM\column(type="string", length=255)
	*/
	protected $meta_title;
    
    /**
	* @ORM\column(type="string", length=500)
	*/
	protected $meta_description;
    
    /**
	* @ORM\column(type="string", length=500)
	*/
	protected $meta_keyboard;    
    
    /**
	* @ORM\column(type="string", length=500, nullable=true)
	*/
	protected $preview;
	
	/**
	* @ORM\column(type="text")
	*/
	protected $description;   
    
    protected $oldpreview;

    /**
    * @ORM\OneToMany(targetEntity="Page", mappedBy="category")
    */
    protected $pages;
    
    public function __construct()
    {
        $this->pages = new ArrayCollection();
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
     * Set description
     *
     * @param string $description
     * @return Category
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
     * Set title
     *
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Category
     */
    public function setMetaTitle($metaTitle)
    {
        $this->meta_title = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Category
     */
    public function setMetaDescription($metaDescription)
    {
        $this->meta_description = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * Set metaKeyboard
     *
     * @param string $metaKeyboard
     *
     * @return Category
     */
    public function setMetaKeyboard($metaKeyboard)
    {
        $this->meta_keyboard = $metaKeyboard;

        return $this;
    }

    /**
     * Get metaKeyboard
     *
     * @return string
     */
    public function getMetaKeyboard()
    {
        return $this->meta_keyboard;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Category
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set siteId
     *
     * @param integer $siteId
     *
     * @return Category
     */
    public function setSiteId($siteId)
    {
        $this->site_id = $siteId;

        return $this;
    }

    /**
     * Get siteId
     *
     * @return integer
     */
    public function getSiteId()
    {
        return $this->site_id;
    }

    /**
     * Set preview
     *
     * @param string $preview
     *
     * @return Category
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;
        return $this;
    }
    
    /**
     * Get preview
     *
     * @return string
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @ORM\PostLoad 
     */
    public function postLoad()
    {
        $this->oldpreview = $this->preview;
    }
    
    public function getSeoUrlKey()
    {
        return 'pages/category/' . $this->getId();
    }
    
    public function isHasSeoUrl()
    {
        return true;
    }
}
