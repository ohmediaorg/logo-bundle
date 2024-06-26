<?php

namespace OHMedia\LogoBundle\Service;

use OHMedia\BackendBundle\Shortcodes\AbstractShortcodeProvider;
use OHMedia\BackendBundle\Shortcodes\Shortcode;
use OHMedia\LogoBundle\Repository\LogoGroupRepository;

class LogoShortcodeProvider extends AbstractShortcodeProvider
{
    public function __construct(private LogoGroupRepository $logoGroupRepository)
    {
    }

    public function getTitle(): string
    {
        return 'Logos';
    }

    public function buildShortcodes(): void
    {
        $logoGroups = $this->logoGroupRepository->createQueryBuilder('lg')
            ->orderBy('lg.title', 'asc')
            ->getQuery()
            ->getResult();

        foreach ($logoGroups as $logoGroup) {
            $id = $logoGroup->getId();

            $this->addShortcode(new Shortcode(
                sprintf('%s (ID:%s)', $logoGroup, $id),
                'logos('.$id.')'
            ));
        }
    }
}
