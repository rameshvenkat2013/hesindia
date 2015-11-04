<?php

namespace Hes\Bundle\IndiaBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User implements UserInterface, EquatableInterface, \Serializable
{
    /**
     * @var string
     */
    private $userEmail;

    /**
     * @var string
     */
    private $userPassword;
	
	private $username;
	
	private $salt;

    /**
     * @var string
     */
    private $userRole;

    /**
     * @var integer
     */
    private $serialId;

    /**
     * @var integer
     */
    private $userLevel;
    
    private $isActive;

	public function __construct() {
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
    }
    
    public function getSalt() {
        return $this->salt;
    }
	
	 public function isEqualTo(UserInterface $user)
      {
        return $this->serialId === $user->getSerialId();
      }
	  
	   public function getUsername() {
        return $this->userEmail;
    }
	
	public function getPassword()
    {
        return $this->userPassword;
    }
	
	public function getRoles() {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() 
            {
        
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize() {
        return serialize(array(
            $this->serialId,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized) {
        list (
                $this->serialId,
                ) = unserialize($serialized);
    }
    
   
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
     * Set userLevel
     *
     * @param integer $userLevel
     * @return User
     */
    public function setUserLevel($userLevel)
    {
        $this->userLevel = $userLevel;

        return $this;
    }

    /**
     * Get userLevel
     *
     * @return integer 
     */
    public function getUserLevel()
    {
        return $this->userLevel;
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
