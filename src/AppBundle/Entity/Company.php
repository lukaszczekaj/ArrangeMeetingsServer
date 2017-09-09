<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity
 */
class Company
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="text", length=65535, nullable=false)
     */
    private $pass;

    /**
     * @var string
     *
     * @ORM\Column(name="addressStreet", type="string", length=100, nullable=true)
     */
    private $addressstreet;

    /**
     * @var string
     *
     * @ORM\Column(name="addressCity", type="string", length=45, nullable=true)
     */
    private $addresscity;

    /**
     * @var string
     *
     * @ORM\Column(name="addressPostalCode", type="string", length=6, nullable=true)
     */
    private $addresspostalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="imgurl", type="text", length=65535, nullable=true)
     */
    private $imgurl;

    /**
     * @var string
     *
     * @ORM\Column(name="authToken", type="string", length=64, nullable=true)
     */
    private $authtoken;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Company
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
     * Set pass
     *
     * @param string $pass
     *
     * @return Company
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set addressstreet
     *
     * @param string $addressstreet
     *
     * @return Company
     */
    public function setAddressstreet($addressstreet)
    {
        $this->addressstreet = $addressstreet;

        return $this;
    }

    /**
     * Get addressstreet
     *
     * @return string
     */
    public function getAddressstreet()
    {
        return $this->addressstreet;
    }

    /**
     * Set addresscity
     *
     * @param string $addresscity
     *
     * @return Company
     */
    public function setAddresscity($addresscity)
    {
        $this->addresscity = $addresscity;

        return $this;
    }

    /**
     * Get addresscity
     *
     * @return string
     */
    public function getAddresscity()
    {
        return $this->addresscity;
    }

    /**
     * Set addresspostalcode
     *
     * @param string $addresspostalcode
     *
     * @return Company
     */
    public function setAddresspostalcode($addresspostalcode)
    {
        $this->addresspostalcode = $addresspostalcode;

        return $this;
    }

    /**
     * Get addresspostalcode
     *
     * @return string
     */
    public function getAddresspostalcode()
    {
        return $this->addresspostalcode;
    }

    /**
     * Set imgurl
     *
     * @param string $imgurl
     *
     * @return Company
     */
    public function setImgurl($imgurl)
    {
        $this->imgurl = $imgurl;

        return $this;
    }

    /**
     * Get imgurl
     *
     * @return string
     */
    public function getImgurl()
    {
        return $this->imgurl;
    }

    /**
     * Set authtoken
     *
     * @param string $authtoken
     *
     * @return Company
     */
    public function setAuthtoken($authtoken)
    {
        $this->authtoken = $authtoken;

        return $this;
    }

    /**
     * Get authtoken
     *
     * @return string
     */
    public function getAuthtoken()
    {
        return $this->authtoken;
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
}
