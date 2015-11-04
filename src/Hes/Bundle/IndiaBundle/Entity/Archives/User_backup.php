<?php

namespace Hes\Bundle\IndiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User
{
    /**
     * @var string
     */
    private $userEmail;

    /**
     * @var string
     */
    private $userPassword;

    /**
     * @var string
     */
    private $userRole;

    /**
     * @var integer
     */
    private $serialId;


    /**
     * Set userEmail
     *
     * @param string $userEmail
     * @return User
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string 
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     * @return User
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string 
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set userRole
     *
     * @param string $userRole
     * @return User
     */
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;

        return $this;
    }

    /**
     * Get userRole
     *
     * @return string 
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Get serialId
     *
     * @return integer 
     */
    public function getSerialId()
    {
        return $this->serialId;
    }
}
