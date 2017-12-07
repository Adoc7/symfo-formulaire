<?php


namespace JG\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Table(name="jg_user")
 * @ORM\Entity(repositoryClass="JG\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}

//class User
//
//{
//    /**
//     * @ORM\Column(name="id", type="integer")
//     * @ORM\Id
//     * @ORM\GeneratedValue(strategy="AUTO")
//     */
//    private $id;
//    /**
//     * @ORM\Column(name="username", type="string", length=255, unique=true)
//     */
//    private $username;
//    /**
//     * @ORM\Column(name="password", type="string", length=255)
//     */
//    private $password;
//    /**
//     * @ORM\Column(name="salt", type="string", length=255)
//     */
//    private $salt;
//    /**
//     * @ORM\Column(name="roles", type="array")
//     */
//    private $roles = array();
//
//    // Les getters et setters
//
//    public function eraseCredentials()
//{
//}

//}
