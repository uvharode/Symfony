<?php

namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(collection="users")
 */
class User implements UserInterface
{

    /**
     * @MongoDB\Id
     */
    protected $id;
    /** @MongoDB\Field(type="string") */
    protected $username;
    /** @MongoDB\Field(type="string") */
    protected $email;
    /** @MongoDB\Field(type="string") */
    protected $password;
     /** @Assert\Length(max=4096) */
    protected $plainPassword;
    /** @MongoDB\Field(type="string") */
    protected $role;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role = null)
    {
        $this->role = $role;
    }
//////////////////////////////////////////////////////
    public function getRoles()
    {
        return [$this->getRole()];
    }
    public function getSalt()
    {
        return null;
    }
    public function eraseCredentials()
    {
        return null;
    }

}