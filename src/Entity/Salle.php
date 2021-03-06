<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/Entity/Salle.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:20
// @lastUpdate 23/11/2019 09:14

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalleRepository")
 */
class Salle extends BaseEntity
{
    public const SALLE_TD = 'td';
    public const SALLE_TP = 'tp';
    public const SALLE_AMPHI = 'amphi';
    public const SALLE_INFORMATIQUE = 'info';

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"salle_administration"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"salle_administration"})
     */
    private $capacite = 0;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"salle_administration"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="salles")
     * @Groups({"salle_administration"})
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SalleExamen", mappedBy="salle")
     */
    private $salleExamens;

    public function __construct()
    {
        $this->salleExamens = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     *
     * @return Salle
     */
    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    /**
     * @param int $capacite
     *
     * @return Salle
     */
    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Salle
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Site|null
     */
    public function getSite(): ?Site
    {
        return $this->site;
    }

    /**
     * @param Site|null $site
     *
     * @return Salle
     */
    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection|SalleExamen[]
     */
    public function getSalleExamens(): Collection
    {
        return $this->salleExamens;
    }

    public function addSalleExamen(SalleExamen $salleExamen): self
    {
        if (!$this->salleExamens->contains($salleExamen)) {
            $this->salleExamens[] = $salleExamen;
            $salleExamen->setSalle($this);
        }

        return $this;
    }

    public function removeSalleExamen(SalleExamen $salleExamen): self
    {
        if ($this->salleExamens->contains($salleExamen)) {
            $this->salleExamens->removeElement($salleExamen);
            // set the owning side to null (unless already changed)
            if ($salleExamen->getSalle() === $this) {
                $salleExamen->setSalle(null);
            }
        }

        return $this;
    }
}
