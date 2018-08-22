<?php

namespace Sacprd\SeoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="seo")
 */
class Rewrite
{
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
	* @ORM\column(type="string", length=200)
	*/
	protected $url;
    
	/**
	* @ORM\column(type="string", length=200)
	*/
	protected $route;

	/**
	* @ORM\column(type="string", length=255, nullable=true)
	*/
	protected $meta_title;
	
	/**
	* @ORM\column(type="string", length=255, nullable=true)
	*/
	protected $meta_h1;
    
    /**
	* @ORM\column(type="string", length=500, nullable=true)
	*/
	protected $meta_description;
    
    /**
	* @ORM\column(type="string", length=500, nullable=true)
	*/
	protected $meta_keyboard;  

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
     * Set siteId
     *
     * @param integer $siteId
     *
     * @return Rewrite
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
     * Set url
     *
     * @param string $url
     *
     * @return Rewrite
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
     * Set route
     *
     * @param string $route
     *
     * @return Rewrite
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Rewrite
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
     * Set metaH1
     *
     * @param string $metaH1
     *
     * @return Rewrite
     */
    public function setMetaH1($metaH1)
    {
        $this->meta_h1 = $metaH1;

        return $this;
    }

    /**
     * Get metaH1
     *
     * @return string
     */
    public function getMetaH1()
    {
        return $this->meta_h1;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Rewrite
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
     * @return Rewrite
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
}
