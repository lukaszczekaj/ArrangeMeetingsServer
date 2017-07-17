<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alloweddates
 *
 * @ORM\Table(name="allowedDates", indexes={@ORM\Index(name="fk_allowedDates_companyID_idx", columns={"companyID"})})
 * @ORM\Entity
 */
class Alloweddates
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeFrom", type="time", nullable=true)
     */
    private $timefrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeTo", type="time", nullable=true)
     */
    private $timeto;

    /**
     * @var string
     *
     * @ORM\Column(name="dayOfWeek", type="string", length=5, nullable=true)
     */
    private $dayofweek;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Company
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="companyID", referencedColumnName="id")
     * })
     */
    private $companyid;



    /**
     * Set timefrom
     *
     * @param \DateTime $timefrom
     *
     * @return Alloweddates
     */
    public function setTimefrom($timefrom)
    {
        $this->timefrom = $timefrom;

        return $this;
    }

    /**
     * Get timefrom
     *
     * @return \DateTime
     */
    public function getTimefrom()
    {
        return $this->timefrom;
    }

    /**
     * Set timeto
     *
     * @param \DateTime $timeto
     *
     * @return Alloweddates
     */
    public function setTimeto($timeto)
    {
        $this->timeto = $timeto;

        return $this;
    }

    /**
     * Get timeto
     *
     * @return \DateTime
     */
    public function getTimeto()
    {
        return $this->timeto;
    }

    /**
     * Set dayofweek
     *
     * @param string $dayofweek
     *
     * @return Alloweddates
     */
    public function setDayofweek($dayofweek)
    {
        $this->dayofweek = $dayofweek;

        return $this;
    }

    /**
     * Get dayofweek
     *
     * @return string
     */
    public function getDayofweek()
    {
        return $this->dayofweek;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set companyid
     *
     * @param \AppBundle\Entity\Company $companyid
     *
     * @return Alloweddates
     */
    public function setCompanyid(\AppBundle\Entity\Company $companyid = null)
    {
        $this->companyid = $companyid;

        return $this;
    }

    /**
     * Get companyid
     *
     * @return \AppBundle\Entity\Company
     */
    public function getCompanyid()
    {
        return $this->companyid;
    }
}
