<?php

namespace OHMedia\LogoBundle\Security\Voter;

use OHMedia\LogoBundle\Entity\LogoGroup;
use OHMedia\SecurityBundle\Entity\User;
use OHMedia\SecurityBundle\Security\Voter\AbstractEntityVoter;
use OHMedia\WysiwygBundle\Service\Wysiwyg;

class LogoGroupVoter extends AbstractEntityVoter
{
    public const INDEX = 'index';
    public const CREATE = 'create';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    public function __construct(private Wysiwyg $wysiwyg)
    {
    }

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
        return LogoGroup::class;
    }

    protected function canIndex(LogoGroup $logoGroup, User $loggedIn): bool
    {
        return true;
    }

    protected function canCreate(LogoGroup $logoGroup, User $loggedIn): bool
    {
        return true;
    }

    protected function canEdit(LogoGroup $logoGroup, User $loggedIn): bool
    {
        return true;
    }

    protected function canDelete(LogoGroup $logoGroup, User $loggedIn): bool
    {
        $shortcode = sprintf('logos(%d)', $logoGroup->getId());

        return !$this->wysiwyg->shortcodesInUse($shortcode);
    }
}
