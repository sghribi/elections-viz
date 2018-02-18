<?php

namespace AppBundle\Entity;

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
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="codeMin", type="string", length=3)
     * @Assert\NotBlank()
     */
    private $codeMin;

    /**
     * @var string
     *
     * @ORM\Column(name="code3Car", type="string", length=3)
     * @Assert\NotBlank()
     */
    private $code3Car;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nom;


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
}

