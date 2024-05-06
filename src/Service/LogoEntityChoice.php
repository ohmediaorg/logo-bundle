<?php

namespace OHMedia\LogoBundle\Service;

use OHMedia\LogoBundle\Entity\Logo;
use OHMedia\LogoBundle\Entity\LogoGroup;
use OHMedia\SecurityBundle\Service\EntityChoiceInterface;

class LogoEntityChoice implements EntityChoiceInterface
{
    public function getLabel(): string
    {
        return 'Logos';
    }

    public function getEntities(): array
    {
        return [Logo::class, LogoGroup::class];
    }
}
