<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/Entity/Contact.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:20
// @lastUpdate 23/11/2019 09:14

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"alternance_administration", "stage_entreprise_administration"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"alternance_administration", "stage_entreprise_administration"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"alternance_administration", "stage_entreprise_administration"})
     */
    private $fonction;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"alternance_administration", "stage_entreprise_administration"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"alternance_administration", "stage_entreprise_administration"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"alternance_administration"})
     */
    private $portable;

    /**
     * @ORM\Column(type="string", length=3)
     * @Groups({"alternance_administration"})
     */
    private $civilite = 'M.';

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $fax;

    public function __construct()
    {
        $this->civilite = Constantes::CIVILITE_HOMME;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPortable(): ?string
    {
        return $this->portable;
    }

    public function setPortable(string $portable): self
    {
        $this->portable = $portable;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getDisplay(): string
    {
        return $this->civilite . ' ' . ucfirst($this->getPrenom()) . ' ' . mb_strtoupper($this->getNom());
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
