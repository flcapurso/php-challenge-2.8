<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Todo", mappedBy="user")
     */
    private $todos;

    public function __construct()
    {
        $this->todos = new ArrayCollection();

        parent::__construct();
        // your own logic
    }

    /**
     * Add todos
     *
     * @param \AppBundle\Entity\Todo $todos
     * @return User
     */
    public function addTodo(\AppBundle\Entity\Todo $todos)
    {
        $this->todos[] = $todos;

        return $this;
    }

    /**
     * Remove todos
     *
     * @param \AppBundle\Entity\Todo $todos
     */
    public function removeTodo(\AppBundle\Entity\Todo $todos)
    {
        $this->todos->removeElement($todos);
    }

    /**
     * Get todos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTodos()
    {
        return $this->todos;
    }
}
