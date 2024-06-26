<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\MairieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: MairieRepository::class)]
#[ApiResource(
    order: ['ville', 'codePostal'],
    operations:[
         new GetCollection(
             normalizationContext: ["groups" =>["mairies:read:collection"]],
             //security: "is_granted('ROLE_USER')"
         ),
        new Get(
            normalizationContext: ["groups" => ["mairies:read"]],
            //security: "is_granted('ROLE_USER') and object.getOwner() == user"
        ),
        new Post(
            normalizationContext: ["groups" => ["mairies:read"]],
            denormalizationContext: ["groups" => ["mairies:write"]],
            # processor: CreateTravelProcessor::class
            #security: "is_granted('ROLE_USER')"
        ),
        new Patch(
            normalizationContext: ["groups" => ["mairies:read"]],
            denormalizationContext: ["groups" => ["mairies:write"]],
            #security: "is_granted('ROLE_USER') and object.getOwner() == user"
        ),
        new Delete(
            #security: "is_granted('ROLE_USER') and object.getOwner() == user"
        )
     ]
 )]
#[ApiFilter(SearchFilter::class, properties: ['codePostal' => 'partial', 'ville' => 'partial', 'departement' => 'partial'])]
class Mairie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    #[Groups(["mairies:read", "mairies:write"])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(max: 6)]
    private ?string $codeInsee = null;

    #[ORM\Column(length: 5)]
    #[Groups(["mairies:read:collection", "mairies:read", "mairies:write"])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 5, max: 5)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 180)]
    #[Groups(["mairies:read:collection", "mairies:read", "mairies:write"])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(max: 180)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    #[Groups(["mairies:read:collection", "mairies:read", "mairies:write"])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(max: 180)]
    private ?string $adresse = null;

    #[ORM\Column(length: 100)]
    #[Groups(["mairies:read:collection", "mairies:read", "mairies:write"])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(max: 100)]
    private ?string $ville = null;

    #[ORM\Column(length: 255,nullable: true)]
    #[Assert\Length(max: 255)]
    #[Groups(["mairies:read", "mairies:write"])]
    private ?string $siteWeb = null;

    #[ORM\Column(length: 25,nullable: true)]
    #[Groups(["mairies:read", "mairies:write"])]
    #[Assert\Length(max: 25)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255,nullable: true)]
    #[Groups(["mairies:read", "mairies:write"])]
    private ?string $email = null;

    #[ORM\Column(length: 20,nullable: true)]
    #[Groups(["mairies:read:collection", "mairies:read", "mairies:write"])]
    #[Assert\Length(max: 20)]
    private ?string $latitude = null;

    #[ORM\Column(length: 20,nullable: true)]
    #[Groups(["mairies:read:collection", "mairies:read", "mairies:write"])]
    #[Assert\Length(max: 20)]
    private ?string $longitude = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["mairies:read", "mairies:write"])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?\DateTimeInterface $dateMaj = null;

    #[ORM\ManyToOne(inversedBy: 'mairies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["mairies:read", "mairies:write"])]
    private ?Departement $departement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeInsee(): ?string
    {
        return $this->codeInsee;
    }

    public function setCodeInsee(string $codeInsee): static
    {
        $this->codeInsee = $codeInsee;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(string $siteWeb): static
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getDateMaj(): ?\DateTimeInterface
    {
        return $this->dateMaj;
    }

    public function setDateMaj(\DateTimeInterface $dateMaj): static
    {
        $this->dateMaj = $dateMaj;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }
}
