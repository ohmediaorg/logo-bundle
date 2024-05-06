<?php

namespace OHMedia\LogoBundle\Security\Voter;

use OHMedia\LogoBundle\Entity\Logo;
use OHMedia\SecurityBundle\Entity\User;
use OHMedia\SecurityBundle\Security\Voter\AbstractEntityVoter;

class LogoVoter extends AbstractEntityVoter
{
    public const INDEX = 'index';
    public const CREATE = 'create';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function getAttributes(): array
    {
        return [
            self::INDEX,
            self::CREATE,
            self::EDIT,
            self::DELETE,
        ];
    }

    protected function getEntityClass(): string
    {
        return Logo::class;
    }

    protected function canIndex(Logo $logo, User $loggedIn): bool
    {
        return true;
    }

    protected function canCreate(Logo $logo, User $loggedIn): bool
    {
        return true;
    }

    protected function canEdit(Logo $logo, User $loggedIn): bool
    {
        return true;
    }

    protected function canDelete(Logo $logo, User $loggedIn): bool
    {
        return true;
    }
}
