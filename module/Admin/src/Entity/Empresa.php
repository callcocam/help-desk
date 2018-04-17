<?php

namespace Admin\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Core\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="Admin\Repository\EmpresaRepository")
 * @ORM\Entity
 */
class Empresa extends AbstractEntity
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
     * @var int
     *
     * @ORM\Column(name="tipo", type="integer", nullable=false, options={"default"="1"})
     */
    private $tipo = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=255, nullable=false, options={"default"="/dist/uploads/images/no_image.jpg"})
     */
    private $cover = '/dist/uploads/images/no_image.jpg';

    /**
     * @var string|null
     *
     * @ORM\Column(name="social", type="string", length=220, nullable=true, options={"default"="NOVA EMPRESA"})
     */
    private $social = 'NOVA EMPRESA';

    /**
     * @var string|null
     *
     * @ORM\Column(name="fantasia", type="string", length=60, nullable=true, options={"default"="NOVA EMPRESA"})
     */
    private $fantasia = 'NOVA EMPRESA';

    /**
     * @var string|null
     *
     * @ORM\Column(name="cnpj", type="string", length=14, nullable=true)
     */
    private $cnpj;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ie", type="string", length=14, nullable=true, options={"default"="ISENTO"})
     */
    private $ie = 'ISENTO';

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=50, nullable=true, options={"default"="(48)35351603"})
     */
    private $phone = '(48)35351603';

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=220, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="google", type="string", length=50, nullable=false)
     */
    private $google = '';

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=50, nullable=false, options={"default"="claudio.coelho.175"})
     */
    private $facebook = 'claudio.coelho.175';

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=50, nullable=false, options={"default"="callcocam"})
     */
    private $twitter = 'callcocam';

    /**
     * @var string|null
     *
     * @ORM\Column(name="street", type="string", length=60, nullable=true, options={"default"="Rua Oscar de Oliveira Lopes"})
     */
    private $street = 'Rua Oscar de Oliveira Lopes';

    /**
     * @var string|null
     *
     * @ORM\Column(name="complements", type="string", length=60, nullable=true, options={"default"="Complement"})
     */
    private $complements = 'Complement';

    /**
     * @var string|null
     *
     * @ORM\Column(name="number", type="string", length=10, nullable=true, options={"default"="355"})
     */
    private $number = '355';

    /**
     * @var string|null
     *
     * @ORM\Column(name="district", type="string", length=30, nullable=true, options={"default"="Bela Vista"})
     */
    private $district = 'Bela Vista';

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip", type="string", length=8, nullable=true, options={"default"="88950000"})
     */
    private $zip = '88950000';

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=30, nullable=true, options={"default"="Jacinto Machado"})
     */
    private $city = 'Jacinto Machado';

    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="string", length=2, nullable=true, options={"default"="SC"})
     */
    private $state = 'SC';

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=20, nullable=true, options={"default"="BRASIL"})
     */
    private $country = 'BRASIL';

    /**
     * @var string
     *
     * @ORM\Column(name="longetude", type="string", length=20, nullable=false, options={"default"="-49.7612579"})
     */
    private $longetude = '-49.7612579';

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=20, nullable=false, options={"default"="-29.0003557"})
     */
    private $latitude = '-29.0003557';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default"="1"})
     */
    private $status = '1';

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
     * Set empresa.
     *
     * @param int|null $empresa
     *
     * @return Empresa
     */
    public function setEmpresa($empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa.
     *
     * @return int|null
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set tipo.
     *
     * @param int $tipo
     *
     * @return Empresa
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return int
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set cover.
     *
     * @param string $cover
     *
     * @return Empresa
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover.
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set social.
     *
     * @param string|null $social
     *
     * @return Empresa
     */
    public function setSocial($social = null)
    {
        $this->social = $social;

        return $this;
    }

    /**
     * Get social.
     *
     * @return string|null
     */
    public function getSocial()
    {
        return $this->social;
    }

    /**
     * Set fantasia.
     *
     * @param string|null $fantasia
     *
     * @return Empresa
     */
    public function setFantasia($fantasia = null)
    {
        $this->fantasia = $fantasia;

        return $this;
    }

    /**
     * Get fantasia.
     *
     * @return string|null
     */
    public function getFantasia()
    {
        return $this->fantasia;
    }

    /**
     * Set cnpj.
     *
     * @param string|null $cnpj
     *
     * @return Empresa
     */
    public function setCnpj($cnpj = null)
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    /**
     * Get cnpj.
     *
     * @return string|null
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set ie.
     *
     * @param string|null $ie
     *
     * @return Empresa
     */
    public function setIe($ie = null)
    {
        $this->ie = $ie;

        return $this;
    }

    /**
     * Get ie.
     *
     * @return string|null
     */
    public function getIe()
    {
        return $this->ie;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return Empresa
     */
    public function setPhone($phone = null)
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
     * Set email.
     *
     * @param string|null $email
     *
     * @return Empresa
     */
    public function setEmail($email = null)
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
     * Set google.
     *
     * @param string $google
     *
     * @return Empresa
     */
    public function setGoogle($google)
    {
        $this->google = $google;

        return $this;
    }

    /**
     * Get google.
     *
     * @return string
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * Set facebook.
     *
     * @param string $facebook
     *
     * @return Empresa
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook.
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter.
     *
     * @param string $twitter
     *
     * @return Empresa
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter.
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set street.
     *
     * @param string|null $street
     *
     * @return Empresa
     */
    public function setStreet($street = null)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street.
     *
     * @return string|null
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set complements.
     *
     * @param string|null $complements
     *
     * @return Empresa
     */
    public function setComplements($complements = null)
    {
        $this->complements = $complements;

        return $this;
    }

    /**
     * Get complements.
     *
     * @return string|null
     */
    public function getComplements()
    {
        return $this->complements;
    }

    /**
     * Set number.
     *
     * @param string|null $number
     *
     * @return Empresa
     */
    public function setNumber($number = null)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return string|null
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set district.
     *
     * @param string|null $district
     *
     * @return Empresa
     */
    public function setDistrict($district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district.
     *
     * @return string|null
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set zip.
     *
     * @param string|null $zip
     *
     * @return Empresa
     */
    public function setZip($zip = null)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip.
     *
     * @return string|null
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city.
     *
     * @param string|null $city
     *
     * @return Empresa
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state.
     *
     * @param string|null $state
     *
     * @return Empresa
     */
    public function setState($state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return string|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country.
     *
     * @param string|null $country
     *
     * @return Empresa
     */
    public function setCountry($country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set longetude.
     *
     * @param string $longetude
     *
     * @return Empresa
     */
    public function setLongetude($longetude)
    {
        $this->longetude = $longetude;

        return $this;
    }

    /**
     * Get longetude.
     *
     * @return string
     */
    public function getLongetude()
    {
        return $this->longetude;
    }

    /**
     * Set latitude.
     *
     * @param string $latitude
     *
     * @return Empresa
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Empresa
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return Empresa
     */
    public function setStatus($status)
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
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Empresa
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Empresa
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
