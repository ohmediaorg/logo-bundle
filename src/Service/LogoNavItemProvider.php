<?php

namespace OHMedia\LogoBundle\Service;

use OHMedia\BackendBundle\Service\AbstractNavItemProvider;
use OHMedia\BootstrapBundle\Component\Nav\NavDropdown;
use OHMedia\BootstrapBundle\Component\Nav\NavItemInterface;
use OHMedia\BootstrapBundle\Component\Nav\NavLink;
use OHMedia\LogoBundle\Entity\Logo;
use OHMedia\LogoBundle\Entity\LogoGroup;
use OHMedia\LogoBundle\Security\Voter\LogoGroupVoter;
use OHMedia\LogoBundle\Security\Voter\LogoVoter;

class LogoNavItemProvider extends AbstractNavItemProvider
{
    public function getNavItem(): ?NavItemInterface
    {
        $dropdown = (new NavDropdown('Logos'))
            ->setIcon('patch-check');

        if ($this->isGranted(LogoGroupVoter::INDEX, new LogoGroup())) {
            $groupsLink = (new NavLink('Groups', 'logo_group_index'))
                ->setIcon('collection');

            $dropdown->addLink($groupsLink);
        }

        if ($this->isGranted(LogoVoter::INDEX, new Logo())) {
            $logosLink = (new NavLink('Logos', 'logo_index'))
                ->setIcon('patch-check');

            $dropdown->addLink($logosLink);
        }

        return $dropdown;
    }
}
