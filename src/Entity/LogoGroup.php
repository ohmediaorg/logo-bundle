<?php

namespace OHMedia\LogoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OHMedia\LogoBundle\Repository\LogoGroupRepository;
use OHMedia\UtilityBundle\Entity\BlameableEntityTrait;

#[ORM\Entity(repositoryClass: LogoGroupRepository::class)]
class LogoGroup
{
    use BlameableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, Logo>
     */
    #[ORM\ManyToMany(targetEntity: Logo::class, inversedBy: 'groups')]
    private Collection $logos;

    public function __construct()
    {
        $this->logos = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Logo>
     */
    public function getLogos(): Collection
    {
        return $this->logos;
    }

    public function addLogo(Logo $logo): static
    {
        if (!$this->logos->contains($logo)) {
            $this->logos->add($logo);
        }

        return $this;
    }

    public function removeLogo(Logo $logo): static
    {
        $this->logos->removeElement($logo);

        return $this;
    }
}
