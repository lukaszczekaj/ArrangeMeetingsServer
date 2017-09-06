<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Excludeddates
 *
 * @ORM\Table(name="excludedDates", indexes={@ORM\Index(name="fk_excludedDates_companyID_idx", columns={"companyID"})})
 * @ORM\Entity
 */
class Excludeddates
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFrom", type="time", nullable=true)
     */
    private $datefrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTo", type="time", nullable=true)
     */
    private $dateto;

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
     * Set datefrom
     *
     * @param \DateTime $datefrom
     *
     * @return Excludeddates
     */
    public function setDatefrom($datefrom)
    {
        $this->datefrom = $datefrom;

        return $this;
    }

    /**
     * Get datefrom
     *
     * @return \DateTime
     */
    public function getDatefrom()
    {
        return $this->datefrom;
    }

    /**
     * Set dateto
     *
     * @param \DateTime $dateto
     *
     * @return Excludeddates
     */
    public function setDateto($dateto)
    {
        $this->dateto = $dateto;

        return $this;
    }

    /**
     * Get dateto
     *
     * @return \DateTime
     */
    public function getDateto()
    {
        return $this->dateto;
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
     * @return Excludeddates
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
