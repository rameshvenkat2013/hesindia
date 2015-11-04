<?php

namespace Hes\Bundle\IndiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketsRemarksStatus
 */
class TicketsRemarksStatus
{
    /**
     * @var integer
     */
    private $ticketId;

    /**
     * @var integer
     */
    private $enggId;

    /**
     * @var string
     */
    private $enggEmail;

    /**
     * @var string
     */
    private $enggName;

    /**
     * @var integer
     */
    private $enggRemarks;

    /**
     * @var integer
     */
    private $rowId;


    /**
     * Set ticketId
     *
     * @param integer $ticketId
     * @return TicketsRemarksStatus
     */
    public function setTicketId($ticketId)
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    /**
     * Get ticketId
     *
     * @return integer 
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * Set enggId
     *
     * @param integer $enggId
     * @return TicketsRemarksStatus
     */
    public function setEnggId($enggId)
    {
        $this->enggId = $enggId;

        return $this;
    }

    /**
     * Get enggId
     *
     * @return integer 
     */
    public function getEnggId()
    {
        return $this->enggId;
    }

    /**
     * Set enggEmail
     *
     * @param string $enggEmail
     * @return TicketsRemarksStatus
     */
    public function setEnggEmail($enggEmail)
    {
        $this->enggEmail = $enggEmail;

        return $this;
    }

    /**
     * Get enggEmail
     *
     * @return string 
     */
    public function getEnggEmail()
    {
        return $this->enggEmail;
    }


    /**
     * Set enggName
     *
     * @param string $enggName
     * @return TicketsRemarksStatus
     */
    public function setEnggName($enggName)
    {
        $this->enggName = $enggName;

        return $this;
    }

    /**
     * Get enggName
     *
     * @return string 
     */
    public function getEnggName()
    {
        return $this->enggName;
    }

    /**
     * Set enggRemarks
     *
     * @param integer $enggRemarks
     * @return TicketsRemarksStatus
     */
    public function setEnggRemarks($enggRemarks)
    {
        $this->enggRemarks = $enggRemarks;

        return $this;
    }

    /**
     * Get enggRemarks
     *
     * @return integer 
     */
    public function getEnggRemarks()
    {
        return $this->enggRemarks;
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
