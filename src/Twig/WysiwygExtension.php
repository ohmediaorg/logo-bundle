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
            new TwigFunction('logo_group_grid', [$this, 'logoGroupGrid'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
            new TwigFunction('logo_group_slider', [$this, 'logoGroupSlider'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
        ];
    }

    public function logoGroupGrid(Environment $twig, int $id = null)
    {
        return $this->renderLogos($id, '@OHMediaLogo/logo_group_grid.html.twig');
    }

    public function logoGroupSlider(Environment $twig, int $id = null)
    {
        return $this->renderLogos($id, '@OHMediaLogo/logo_group_slider.html.twig');
    }

    private function renderLogos(?int $id, string $template): string
    {
        $logoGroup = $this->logoGroupRepository
            ->createQueryBuilder('lg')
            ->join('lg.logos', 'l')
            ->where('lg.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        if (!$logoGroup) {
            return '';
        }

        $logos = $logoGroup->getLogos();

        if (!$logos) {
            return '';
        }

        shuffle($logos);

        return $twig->render($template, [
            'logo_group' => $logoGroup,
            'logos' => $logos,
        ]);
    }
}
