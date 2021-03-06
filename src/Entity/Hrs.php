<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/Entity/Hrs.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:20
// @lastUpdate 23/11/2019 09:14

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HrsRepository")
 */
class Hrs extends BaseEntity
{
    /**
     * @ORM\Column(type="float")
     * @Groups({"hrs_administration"})
     */
    private $nbHeuresTd;

    /**
     * @ORM\Column(type="string", length=150)
     * @Groups({"hrs_administration"})
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Semestre", inversedBy="hrs")
     * @Groups({"hrs_administration"})
     */
    private $semestre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Diplome", inversedBy="hrs")
     */
    private $diplome;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnel", inversedBy="hrs")
     * @Groups({"hrs_administration"})
     */
    private $personnel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeHrs", inversedBy="hrs")
     * @Groups({"hrs_administration"})
     */
    private $typeHrs;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="hrs")
     */
    private $departement;

    /**
     * @return float|null
     */
    public function getNbHeuresTd(): ?float
    {
        return $this->nbHeuresTd;
    }

    /**
     * @param float $nbHeuresTd
     *
     * @return Hrs
     */
    public function setNbHeuresTd(float $nbHeuresTd): self
    {
        $this->nbHeuresTd = $nbHeuresTd;

        return $this;
    }

    /**
     * @return Semestre|null
     */
    public function getSemestre(): ?Semestre
    {
        return $this->semestre;
    }

    /**
     * @param Semestre|null $semestre
     *
     * @return Hrs
     */
    public function setSemestre(?Semestre $semestre): self
    {
        $this->semestre = $semestre;

        return $this;
    }

    /**
     * @return Diplome|null
     */
    public function getDiplome(): ?Diplome
    {
        return $this->diplome;
    }

    /**
     * @param Diplome|null $diplome
     *
     * @return Hrs
     */
    public function setDiplome(?Diplome $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    /**
     * @return Personnel|null
     */
    public function getPersonnel(): ?Personnel
    {
        return $this->personnel;
    }

    /**
     * @param Personnel|null $personnel
     *
     * @return Hrs
     */
    public function setPersonnel(?Personnel $personnel): self
    {
        $this->personnel = $personnel;

        return $this;
    }

    /**
     * @return TypeHrs|null
     */
    public function getTypeHrs(): ?TypeHrs
    {
        return $this->typeHrs;
    }

    /**
     * @param TypeHrs|null $typeHrs
     *
     * @return Hrs
     */
    public function setTypeHrs(?TypeHrs $typeHrs): self
    {
        $this->typeHrs = $typeHrs;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle): void
    {
        $this->libelle = $libelle;
    }

    /**
     * @return int|null
     */
    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    /**
     * @param int $annee
     *
     * @return Hrs
     */
    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Hrs constructor.
     *
     * @param Departement $departement
     */
    public function __construct(Departement $departement)
    {
        $this->annee = $departement->getOptAnneePrevisionnel();
        $this->departement = $departement;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }
}
