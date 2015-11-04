<?php

namespace Hes\Bundle\IndiaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * ContactUs
 */
class ContactUs
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $contactNo;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $subject;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $message;

    /**
     * @var integer
     */
    private $rowId;


    /**
     * Set firstName
     *
     * @param string $firstName
     * @return ContactUs
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return ContactUs
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ContactUs
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contactNo
     *
     * @param string $contactNo
     * @return ContactUs
     */
    public function setContactNo($contactNo)
    {
        $this->contactNo = $contactNo;

        return $this;
    }

    /**
     * Get contactNo
     *
     * @return string 
     */
    public function getContactNo()
    {
        return $this->contactNo;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return ContactUs
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return ContactUs
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get rowId
     *
     * @return integer 
     */
    public function getRowId()
    {
        return $this->rowId;
    }
}
