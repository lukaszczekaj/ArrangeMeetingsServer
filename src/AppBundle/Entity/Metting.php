<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Metting
 *
 * @ORM\Table(name="metting", indexes={@ORM\Index(name="fk_metting_companyID_idx", columns={"companyID"})})
 * @ORM\Entity
 */
class Metting
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdd", type="datetime", nullable=false)
     */
    private $dateadd = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFrom", type="datetime", nullable=true)
     */
    private $datefrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTo", type="datetime", nullable=true)
     */
    private $dateto;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status = 'NEW';

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=10, nullable=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=45, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=45, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=45, nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

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
     * Set dateadd
     *
     * @param \DateTime $dateadd
     *
     * @return Metting
     */
    public function setDateadd($dateadd)
    {
        $this->dateadd = $dateadd;

        return $this;
    }

    /**
     * Get dateadd
     *
     * @return \DateTime
     */
    public function getDateadd()
    {
        return $this->dateadd;
    }

    /**
     * Set datefrom
     *
     * @param \DateTime $datefrom
     *
     * @return Metting
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
     * @return Metting
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
     * Set status
     *
     * @param string $status
     *
     * @return Metting
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Metting
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Metting
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Metting
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Metting
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Metting
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
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
     * @return Metting
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
