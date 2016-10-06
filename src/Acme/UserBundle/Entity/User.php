<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Todo;

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
    }

    /**
     * Add todos
     *
     * @param \AppBundle\Entity\Todo $todo
     * @return User
     */
    public function addTodo($todo)
    {
        $this->todos->add($todo);

        return $this;
    }

    /**
     * Remove todos
     *
     * @param \AppBundle\Entity\Todo $todo
     */
    public function removeTodo($todo)
    {
        $this->todos->removeElement($todo);
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
