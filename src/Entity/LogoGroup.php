<?php

namespace OHMedia\LogoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OHMedia\LogoBundle\Repository\LogoGroupRepository;
use OHMedia\SecurityBundle\Entity\Traits\BlameableTrait;

#[ORM\Entity(repositoryClass: LogoGroupRepository::class)]
class LogoGroup
{
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __toString(): string
    {
        return 'Group #'.$this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
