<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class User implements UserInterface
{
    const MAX_ADVICED_DAILY_CALORIES = 2500;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column
     */
    private $username;

    /**
     * @ORM\Column
     */
    private $fullname;

    /**
     * @ORM\Column
     */
    private $email;

    /**
     * @ORM\Column
     */
    private $avatarUrl;

    /**
     * @ORM\Column
     */
    private $profileHtmlUrl;

    public function __construct($username, $fullname, $email, $avatarUrl, $profileHtmlUrl)
    {
        $this->username = $username;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->avatarUrl = $avatarUrl;
        $this->profileHtmlUrl = $profileHtmlUrl;
        $this->foodRecords = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    public function getProfileHtmlUrl()
    {
        return $this->profileHtmlUrl;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}