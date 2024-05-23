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
use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
#[ApiResource(
    operations:[
         new GetCollection(
             normalizationContext: ["groups" =>["departements:read:collection"]],
             //security: "is_granted('ROLE_USER')"
         ),
        new Get(
            normalizationContext: ["groups" => ["departements:read"]],
            //security: "is_granted('ROLE_USER') and object.getOwner() == user"
        ),
        new Post(
            normalizationContext: ["groups" => ["departements:read"]],
            denormalizationContext: ["groups" => ["departements:write"]],
            # processor: CreateTravelProcessor::class
            #security: "is_granted('ROLE_USER')"
        ),
        new Patch(
            normalizationContext: ["groups" => ["departements:read"]],
            denormalizationContext: ["groups" => ["departements:write"]],
            #security: "is_granted('ROLE_USER') and object.getOwner() == user"
        ),
        new Delete(
            #security: "is_granted('ROLE_USER') and object.getOwner() == user"
        )
     ]
 )]
 class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private ?string $numero = null;

    #[ORM\Column(length: 100)]
    #[Groups(["departements:read:collection", "departements:read", "departements:write"])]
    private ?string $label = null;
    #[Groups(["departements:read", "departements:write"])]
    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[ORM\OneToMany(targetEntity: Mairie::class, mappedBy: 'departement', orphanRemoval: true)]
    private Collection $mairies;

    public function __construct()
    {
        $this->mairies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

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

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return Collection<int, Mairie>
     */
    public function getMairies(): Collection
    {
        return $this->mairies;
    }

    public function addMairy(Mairie $mairy): static
    {
        if (!$this->mairies->contains($mairy)) {
            $this->mairies->add($mairy);
            $mairy->setDepartement($this);
        }

        return $this;
    }

    public function removeMairy(Mairie $mairy): static
    {
        if ($this->mairies->removeElement($mairy)) {
            // set the owning side to null (unless already changed)
            if ($mairy->getDepartement() === $this) {
                $mairy->setDepartement(null);
            }
        }

        return $this;
    }
}
