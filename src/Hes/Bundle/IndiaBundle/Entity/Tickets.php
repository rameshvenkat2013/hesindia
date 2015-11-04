<?php

namespace Hes\Bundle\IndiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tickets
 */
class Tickets
{
    /**
     * @var string
     */
    private $ticketId;

    /**
     * @var string
     */
    private $jobNo;

    /**
     * @var string
     */
    private $serialNo;

    /**
     * @var string
     */
    private $oldJobNo;

    /**
     * @var integer
     */
    private $inwardDc;

    /**
     * @var integer
     */
    private $outwardDc;

    /**
     * @var string
     */
    private $reportedIssue;

    /**
     * @var string
     */
    private $modelNo;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \DateTime
     */
    private $rgpDate;

    /**
     * @var string
     */
    private $customerId;

    /**
     * @var string
     */
    private $materialDesc;

    /**
     * @var string
     */
    private $kwHp;

    /**
     * @var string
     */
    private $rework;

    /**
     * @var string
     */
    private $reportedStatus;

    /**
     * @var integer
     */
    private $assignedTo;

    /**
     * @var string
     */
    private $ticketStatus;

    /**
     * @var string
     */
    private $remarks;

    /**
     * @var integer
     */
    private $rowId;


    /**
     * Set ticketId
     *
     * @param string $ticketId
     * @return Tickets
     */
    public function setTicketId($ticketId)
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    /**
     * Get ticketId
     *
     * @return string 
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * Set jobNo
     *
     * @param string $jobNo
     * @return Tickets
     */
    public function setJobNo($jobNo)
    {
        $this->jobNo = $jobNo;

        return $this;
    }

    /**
     * Get jobNo
     *
     * @return string 
     */
    public function getJobNo()
    {
        return $this->jobNo;
    }

    /**
     * Set serialNo
     *
     * @param string $serialNo
     * @return Tickets
     */
    public function setSerialNo($serialNo)
    {
        $this->serialNo = $serialNo;

        return $this;
    }

    /**
     * Get serialNo
     *
     * @return string 
     */
    public function getSerialNo()
    {
        return $this->serialNo;
    }

    /**
     * Set oldJobNo
     *
     * @param string $oldJobNo
     * @return Tickets
     */
    public function setOldJobNo($oldJobNo)
    {
        $this->oldJobNo = $oldJobNo;

        return $this;
    }

    /**
     * Get oldJobNo
     *
     * @return string 
     */
    public function getOldJobNo()
    {
        return $this->oldJobNo;
    }

    /**
     * Set inwardDc
     *
     * @param integer $inwardDc
     * @return Tickets
     */
    public function setInwardDc($inwardDc)
    {
        $this->inwardDc = $inwardDc;

        return $this;
    }

    /**
     * Get inwardDc
     *
     * @return integer 
     */
    public function getInwardDc()
    {
        return $this->inwardDc;
    }

    /**
     * Set outwardDc
     *
     * @param integer $outwardDc
     * @return Tickets
     */
    public function setOutwardDc($outwardDc)
    {
        $this->outwardDc = $outwardDc;

        return $this;
    }

    /**
     * Get outwardDc
     *
     * @return integer 
     */
    public function getOutwardDc()
    {
        return $this->outwardDc;
    }

    /**
     * Set reportedIssue
     *
     * @param string $reportedIssue
     * @return Tickets
     */
    public function setReportedIssue($reportedIssue)
    {
        $this->reportedIssue = $reportedIssue;

        return $this;
    }

    /**
     * Get reportedIssue
     *
     * @return string 
     */
    public function getReportedIssue()
    {
        return $this->reportedIssue;
    }

    /**
     * Set modelNo
     *
     * @param string $modelNo
     * @return Tickets
     */
    public function setModelNo($modelNo)
    {
        $this->modelNo = $modelNo;

        return $this;
    }

    /**
     * Get modelNo
     *
     * @return string 
     */
    public function getModelNo()
    {
        return $this->modelNo;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Tickets
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set rgpDate
     *
     * @param \DateTime $rgpDate
     * @return Tickets
     */
    public function setRgpDate($rgpDate)
    {
        $this->rgpDate = $rgpDate;

        return $this;
    }

    /**
     * Get rgpDate
     *
     * @return \DateTime 
     */
    public function getRgpDate()
    {
        return $this->rgpDate;
    }

    /**
     * Set customerId
     *
     * @param string $customerId
     * @return Tickets
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return string 
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set materialDesc
     *
     * @param string $materialDesc
     * @return Tickets
     */
    public function setMaterialDesc($materialDesc)
    {
        $this->materialDesc = $materialDesc;

        return $this;
    }

    /**
     * Get materialDesc
     *
     * @return string 
     */
    public function getMaterialDesc()
    {
        return $this->materialDesc;
    }

    /**
     * Set kwHp
     *
     * @param string $kwHp
     * @return Tickets
     */
    public function setKwHp($kwHp)
    {
        $this->kwHp = $kwHp;

        return $this;
    }

    /**
     * Get kwHp
     *
     * @return string 
     */
    public function getKwHp()
    {
        return $this->kwHp;
    }

    /**
     * Set rework
     *
     * @param string $rework
     * @return Tickets
     */
    public function setRework($rework)
    {
        $this->rework = $rework;

        return $this;
    }

    /**
     * Get rework
     *
     * @return string 
     */
    public function getRework()
    {
        return $this->rework;
    }

    /**
     * Set reportedStatus
     *
     * @param string $reportedStatus
     * @return Tickets
     */
    public function setReportedStatus($reportedStatus)
    {
        $this->reportedStatus = $reportedStatus;

        return $this;
    }

    /**
     * Get reportedStatus
     *
     * @return string 
     */
    public function getReportedStatus()
    {
        return $this->reportedStatus;
    }

    /**
     * Set assignedTo
     *
     * @param integer $assignedTo
     * @return Tickets
     */
    public function setAssignedTo($assignedTo)
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }

    /**
     * Get assignedTo
     *
     * @return integer 
     */
    public function getAssignedTo()
    {
        return $this->assignedTo;
    }

    /**
     * Set ticketStatus
     *
     * @param string $ticketStatus
     * @return Tickets
     */
    public function setTicketStatus($ticketStatus)
    {
        $this->ticketStatus = $ticketStatus;

        return $this;
    }

    /**
     * Get ticketStatus
     *
     * @return string 
     */
    public function getTicketStatus()
    {
        return $this->ticketStatus;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return Tickets
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string 
     */
    public function getRemarks()
    {
        return $this->remarks;
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
