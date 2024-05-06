<?php

namespace OHMedia\LogoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OHMedia\LogoBundle\Repository\LogoRepository;
use OHMedia\SecurityBundle\Entity\Traits\BlameableTrait;

#[ORM\Entity(repositoryClass: LogoRepository::class)]
class Logo
{
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __toString(): string
    {
        return 'Logo #'.$this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
