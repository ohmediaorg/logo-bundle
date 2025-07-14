<?php

namespace OHMedia\LogoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OHMedia\FileBundle\Entity\File;
use OHMedia\LogoBundle\Repository\LogoRepository;
use OHMedia\UtilityBundle\Entity\BlameableEntityTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LogoRepository::class)]
class Logo
{
    use BlameableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 180, nullable: true)]
    #[Assert\Length(max: 180)]
    private ?string $url = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid]
    #[Assert\NotBlank]
    private ?File $image = null;

    /**
     * @var Collection<int, LogoGroup>
     */
    #[ORM\ManyToMany(targetEntity: LogoGroup::class, mappedBy: 'logos')]
    private Collection $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImage(?File $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, LogoGroup>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(LogoGroup $group): static
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
        }

        return $this;
    }

    public function removeGroup(LogoGroup $group): static
    {
        $this->groups->removeElement($group);

        return $this;
    }
}
