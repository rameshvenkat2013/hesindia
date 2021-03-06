<?php

namespace Hes\Bundle\IndiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Services
 */
class Services
{
    /**
     * @var string
     */
    private $mainServices;

    /**
     * @var string
     */
    private $services;

    /**
     * @var string
     */
    private $serviceDescription;

    /**
     * @var integer
     */
    private $serialId;


    /**
     * Set mainServices
     *
     * @param string $mainServices
     * @return Services
     */
    public function setMainServices($mainServices)
    {
        $this->mainServices = $mainServices;

        return $this;
    }

    /**
     * Get mainServices
     *
     * @return string 
     */
    public function getMainServices()
    {
        return $this->mainServices;
    }

    /**
     * Set services
     *
     * @param string $services
     * @return Services
     */
    public function setServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Get services
     *
     * @return string 
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set serviceDescription
     *
     * @param string $serviceDescription
     * @return Services
     */
    public function setServiceDescription($serviceDescription)
    {
        $this->serviceDescription = $serviceDescription;

        return $this;
    }

    /**
     * Get serviceDescription
     *
     * @return string 
     */
    public function getServiceDescription()
    {
        return $this->serviceDescription;
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
    /**
     * @var string
     */
    private $serviceFile;


    /**
     * Set serviceFile
     *
     * @param string $serviceFile
     * @return Services
     */
    public function setServiceFile($serviceFile)
    {
        $this->serviceFile = $serviceFile;

        return $this;
    }

    /**
     * Get serviceFile
     *
     * @return string 
     */
    public function getServiceFile()
    {
        return $this->serviceFile;
    }
}
