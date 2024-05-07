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
            new TwigFunction('logos_grid', [$this, 'logosGrid'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
            new TwigFunction('logos_carousel', [$this, 'logosCarousel'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
        ];
    }

    public function logosGrid(Environment $twig, int $id = null)
    {
        return $this->renderLogos($twig, $id, '@OHMediaLogo/logos_grid.html.twig');
    }

    public function logosCarousel(Environment $twig, int $id = null)
    {
        return $this->renderLogos($twig, $id, '@OHMediaLogo/logos_carousel.html.twig');
    }

    private function renderLogos(Environment $twig, ?int $id, string $template): string
    {
        $logoGroup = $this->logoGroupRepository->find($id);

        if (!$logoGroup) {
            return '';
        }

        $logos = $logoGroup->getLogos();

        if (!$logos) {
            return '';
        }

        $logosArray = $logos->toArray();

        shuffle($logosArray);

        return $twig->render($template, [
            'logo_group' => $logoGroup,
            'logos' => $logosArray,
        ]);
    }
}
