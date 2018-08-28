<?php

namespace Sacprd\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sacprd\Core\BaseDBModel;

use Sacprd\Core\FileUploaderTrait;
use AppBundle\Service\FileUploader;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages")
 * @ORM\HasLifecycleCallbacks()
*/
class Page implements BaseDBModel
{
    use FileUploaderTrait;
    
    const LOCAL_PATH = 'images/pages/';
    
	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;
    
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
	* @ORM\column(type="string", length=500, nullable=true)
	*/
	protected $shortdescr;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;
    
    /**
    * @ORM\ManyToOne(targetEntity="Category", inversedBy="pages")
    * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
    */
    protected $category;
    
	/**
	* @ORM\column(type="text")
	*/
	protected $description;
    
    public function getSeoUrlKey()
    {
        return 'page/' . $this->getId();
    }
    
    public function isHasSeoUrl()
    {
        return true;
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
     * Set title
     *
     * @param string $title
     *
     * @return Page
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
     * Set url
     *
     * @param string $url
     *
     * @return Page
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
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Page
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
     * @return Page
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
     * @return Page
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
     * Set preview
     *
     * @param string $preview
     *
     * @return Page
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
     * Set shortdescr
     *
     * @param string $shortdescr
     *
     * @return Page
     */
    public function setShortdescr($shortdescr)
    {
        $this->shortdescr = $shortdescr;

        return $this;
    }

    /**
     * Get shortdescr
     *
     * @return string
     */
    public function getShortdescr()
    {
        return $this->shortdescr;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Page
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
     * Set category
     *
     * @param \Sacprd\PageBundle\Entity\Category $category
     *
     * @return Page
     */
    public function setCategory(\Sacprd\PageBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Sacprd\PageBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    public function getCategoryname()
    {
        return $this->category->getTitle();
    }
    
    /**
     * @ORM\PostLoad 
     */
    public function postLoad()
    {
        $this->oldpreview = $this->preview;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Page
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }
}