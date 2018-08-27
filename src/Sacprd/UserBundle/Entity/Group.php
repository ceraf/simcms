<?php

namespace Sacprd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sacprd\Core\BaseDBModel;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Group implements BaseDBModel
{
    /**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
    protected $id;
    
    /**
    * @ORM\Column(type="string", length=50, unique=true)
    */
    protected $title;
    
    /**
    * @ORM\Column(type="string", length=500)
    */
    protected $description;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $role;
    
    /**
    * @ORM\OneToMany(targetEntity="User", mappedBy="group")
    */
    protected $users;
    
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    
    public function isHasSeoUrl()
    {
        return false;
    }
	
	public function getSeoUrlKey()
	{
		return null;
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
     *
     * @return Group
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
     *
     * @return Group
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
     * Add user
     *
     * @param \Sacprd\UserBundle\Entity\User $user
     *
     * @return Group
     */
    public function addUser(\Sacprd\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Sacprd\UserBundle\Entity\User $user
     */
    public function removeUser(\Sacprd\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Group
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
}