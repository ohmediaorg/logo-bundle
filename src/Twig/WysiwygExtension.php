<?php

namespace OHMedia\LogoBundle\Twig;

use OHMedia\LogoBundle\Repository\LogoGroupRepository;
use OHMedia\WysiwygBundle\Twig\AbstractWysiwygExtension;
use Twig\Environment;
use Twig\TwigFunction;

class WysiwygExtension extends AbstractWysiwygExtension
{
    public function __construct(private LogoGroupRepository $logoGroupRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('logos', [$this, 'logos'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
        ];
    }

    public function logos(Environment $twig, int $id = null): string
    {
        $logoGroup = $id ? $this->logoGroupRepository->find($id) : null;

        if (!$logoGroup) {
            return '';
        }

        $logos = $logoGroup->getLogos();

        if (!$logos) {
            return '';
        }

        $logosArray = $logos->toArray();

        shuffle($logosArray);

        return $twig->render('@OHMediaLogo/logos.html.twig', [
            'logo_group' => $logoGroup,
            'logos' => $logosArray,
        ]);
    }
}
