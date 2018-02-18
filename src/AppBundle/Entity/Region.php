<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegionRepository")
 */
class Region
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
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    private $code;

    const UNKNOWN_REGION_CODE = 'NR';

    /**
     * @var string
     *
     * @ORM\Column(name="code3Car", type="string", length=3, nullable=true)
     * @Assert\Type("string")
     */
    private $code3Car;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\Type("string")
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
     * @return Region
     */
    public function setCode(string $code)
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
     * Set code3Car
     *
     * @param string $code3Car
     *
     * @return Region
     */
    public function setCode3Car(string $code3Car = null)
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
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     *
     * @return Region
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }
}

