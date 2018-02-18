<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Departement
 *
 * @ORM\Table(name="departement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartementRepository")
 */
class Departement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=3)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="codeMin", type="string", length=3)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $codeMin;

    /**
     * @var string
     *
     * @ORM\Column(name="code3Car", type="string", length=3)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $code3Car;

    /**
     * @var integer
     *
     * @ORM\Column(name="numOrdre", type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type("int")
     */
    private $numOrdre;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Region", inversedBy="departements", cascade={"persist"})
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=false)
     */
    private $region;

    /**
     * @var Commune[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commune", cascade={"persist", "remove"}, mappedBy="departement", orphanRemoval=true)
     * @ORM\OrderBy({"nom" = "ASC"})
     */
    private $communes;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) ($this->nom ?? $this->code ?? $this->id);
    }

    public function __construct()
    {
        $this->communes = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Departement
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set codeMin
     *
     * @param string $codeMin
     *
     * @return Departement
     */
    public function setCodeMin($codeMin)
    {
        $this->codeMin = $codeMin;

        return $this;
    }

    /**
     * Get codeMin
     *
     * @return string
     */
    public function getCodeMin()
    {
        return $this->codeMin;
    }

    /**
     * Set code3Car
     *
     * @param string $code3Car
     *
     * @return Departement
     */
    public function setCode3Car($code3Car)
    {
        $this->code3Car = $code3Car;

        return $this;
    }

    /**
     * Get code3Car
     *
     * @return string
     */
    public function getCode3Car()
    {
        return $this->code3Car;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Departement
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set region
     *
     * @param Region $region
     *
     * @return Departement
     */
    public function setRegion(Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add commune
     *
     * @param Commune $commune
     *
     * @return Departement
     */
    public function addCommune(Commune $commune)
    {
        $this->communes[] = $commune;
        $commune->setDepartement($this);

        return $this;
    }

    /**
     * Remove commune
     *
     * @param Commune $commune
     */
    public function removeCommune(Commune $commune)
    {
        $this->communes->removeElement($commune);
        $commune->setDepartement(null);
    }

    /**
     * Get communes
     *
     * @return Collection|Commune[]
     */
    public function getCommunes()
    {
        return $this->communes;
    }

    /**
     * Set numOrdre
     *
     * @param integer $numOrdre
     *
     * @return Departement
     */
    public function setNumOrdre($numOrdre)
    {
        $this->numOrdre = $numOrdre;

        return $this;
    }

    /**
     * Get numOrdre
     *
     * @return integer
     */
    public function getNumOrdre()
    {
        return $this->numOrdre;
    }
}
