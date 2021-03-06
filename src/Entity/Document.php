<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/Entity/Document.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:20
// @lastUpdate 23/11/2019 09:14

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 * @Vich\Uploadable
 */
class Document extends BaseEntity
{
    /**
     * @var UuidInterface
     *
     * @ORM\Column(type="uuid_binary", unique=true)
     */
    protected $uuid;

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $taille;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $typeFichier;

    /**
     * @var TypeDocument
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDocument", inversedBy="documents")
     */
    private $typeDocument;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $documentName;

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="documentFile", fileNameProperty="documentName", size="taille",
     *                                               mimeType="typeFichier")
     */
    private $documentFile;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Semestre", inversedBy="documents")
     */
    private $semestres;

    /**
     * Document constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->semestres = new ArrayCollection();
    }

    /**
     * @return float|null
     */
    public function getTaille(): ?float
    {
        return $this->taille;
    }

    /**
     * @param float $taille
     *
     * @return Document
     */
    public function setTaille(?float $taille = 0.0): self
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTypeFichier(): ?string
    {
        return $this->typeFichier;
    }

    /**
     * @param string $typeFichier
     *
     * @return Document
     */
    public function setTypeFichier(?string $typeFichier): self
    {
        $this->typeFichier = $typeFichier;

        return $this;
    }

    /**
     * @return TypeDocument
     */
    public function getTypeDocument(): ?TypeDocument
    {
        return $this->typeDocument;
    }

    /**
     * @param TypeDocument $typeDocument
     *
     * @return Document
     */
    public function setTypeDocument(TypeDocument $typeDocument): self
    {
        $this->typeDocument = $typeDocument;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Document
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     *
     * @return Document
     */
    public function setLibelle($libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }


    /**
     * @param File|null $documentFile
     *
     * @throws Exception
     */
    public function setDocumentFile(?File $documentFile = null): void
    {
        $this->documentFile = $documentFile;

        if (null !== $documentFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new DateTime());
        }
    }

    /**
     * @return null|File
     */
    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    /**
     * @return string
     */
    public function getDocumentName(): ?string
    {
        return $this->documentName;
    }

    /**
     * @param string $documentName
     */
    public function setDocumentName(?string $documentName): void
    {
        $this->documentName = $documentName;
    }

    /**
     * @return Collection|Semestre[]
     */
    public function getSemestres(): Collection
    {
        return $this->semestres;
    }

    /**
     * @param Semestre $semestre
     *
     * @return Document
     */
    public function addSemestre(Semestre $semestre): self
    {
        if (!$this->semestres->contains($semestre)) {
            $this->semestres[] = $semestre;
        }

        return $this;
    }

    /**
     * @param Semestre $semestre
     *
     * @return Document
     */
    public function removeSemestre(Semestre $semestre): self
    {
        if ($this->semestres->contains($semestre)) {
            $this->semestres->removeElement($semestre);
        }

        return $this;
    }

    public function getUuidString(): string
    {
        return (string)$this->getUuid();
    }

    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function duplicate(Document $document)
    {
        $this->setLibelle($document->getLibelle());
        $this->setDescription($document->getDescription());
        $this->setTypeDocument($document->getTypeDocument());
        $this->setDocumentName($document->getDocumentName());
        $this->setTaille($document->getTaille());
        $this->setTypeFichier($document->getTypeFichier());
        foreach ($document->getSemestres() as $semestre) {
            $this->addSemestre($semestre);
        }

        return $this;
    }
}
