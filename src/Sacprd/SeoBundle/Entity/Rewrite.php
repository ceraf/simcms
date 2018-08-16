<?php

namespace Sacprd\SeoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rewrite_urls")
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
}
