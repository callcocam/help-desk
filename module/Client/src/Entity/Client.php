<?php

namespace Client\Entity;

use Core\Entity\AbstractEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="\Client\Repository\ClientRepository")
 */
class Client extends AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Empresa")
     * @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     */
    private $empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="document", type="string", length=14, nullable=false)
     */
    private $document;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=200, nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=10, nullable=false, options={"comment"="numero do endereço"})
     */
    private $number;

    /**
     * @var string|null
     *
     * @ORM\Column(name="complement", type="string", length=30, nullable=true)
     */
    private $complement;

    /**
     * @var string
     *
     * @ORM\Column(name="district", type="string", length=60, nullable=false)
     */
    private $district;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=8, nullable=false)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=100, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=2, nullable=false, options={"fixed"=true})
     */
    private $state;

    /**
     * @var string|null
     *
     * @ORM\Column(name="profession", type="string", length=50, nullable=true)
     */
    private $profession;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"comment"="Se o cadastro foi confirmado. 1-sim; 0-nao"})
     */
    private $status = '0';
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="registration_token", type="string", length=255, nullable=true)
     */
    private $registrationToken;

    /**
     * @var \DateTime|null
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param int|null $empresa
     * @return Client
     */
    public function setEmpresa( $empresa )
    {
        $this->empresa = $empresa;
        return $this;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Client
     */
    public function setName( $name )
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set document.
     *
     * @param string $document
     *
     * @return Client
     */
    public function setDocument( $document )
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document.
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Client
     */
    public function setEmail( $email = null )
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return Client
     */
    public function setPhone( $phone = null )
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set street.
     *
     * @param string $street
     *
     * @return Client
     */
    public function setStreet( $street )
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street.
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set number.
     *
     * @param string $number
     *
     * @return Client
     */
    public function setNumber( $number )
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set complement.
     *
     * @param string|null $complement
     *
     * @return Client
     */
    public function setComplement( $complement = null )
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Get complement.
     *
     * @return string|null
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set district.
     *
     * @param string $district
     *
     * @return Client
     */
    public function setDistrict( $district )
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district.
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set zip.
     *
     * @param string $zip
     *
     * @return Client
     */
    public function setZip( $zip )
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip.
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return Client
     */
    public function setCity( $city )
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return Client
     */
    public function setState( $state )
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set profession.
     *
     * @param string|null $profession
     *
     * @return Client
     */
    public function setProfession( $profession = null )
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession.
     *
     * @return string|null
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return Client
     */
    public function setStatus( $status )
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Client
     */
    public function setPassword( string $password ): Client
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Set registrationToken.
     *
     * @param string|null $registrationToken
     *
     * @return Client
     */
    public function setRegistrationToken( $registrationToken = null )
    {
        $this->registrationToken = $registrationToken;

        return $this;
    }

    /**
     * Get registrationToken.
     *
     * @return string|null
     */
    public function getRegistrationToken()
    {
        return $this->registrationToken;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Client
     */
    public function setCreatedAt( $createdAt )
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updateAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return Client
     */
    public function setUpdatedAt( $updatedAt = null )
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updateAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
