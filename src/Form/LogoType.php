<?php

namespace OHMedia\LogoBundle\Form;

use OHMedia\FileBundle\Form\Type\FileEntityType;
use OHMedia\LogoBundle\Entity\Logo;
use OHMedia\LogoBundle\Entity\LogoGroup;
use OHMedia\LogoBundle\Repository\LogoGroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogoType extends AbstractType
{
    public function __construct(private LogoGroupRepository $logoGroupRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $logo = $options['data'];

        $builder->add('name');

        $builder->add('url', UrlType::class, [
            'required' => false,
        ]);

        $builder->add('image', FileEntityType::class, [
            'image' => true,
            'data' => $logo->getImage(),
        ]);

        $logoGroups = $this->logoGroupRepository
            ->createQueryBuilder('lg')
            ->orderBy('lg.title', 'ASC')
            ->getQuery()
            ->getResult();

        if ($logoGroups) {
            $builder->add('groups', EntityType::class, [
                'class' => LogoGroup::class,
                'choices' => $logoGroups,
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Logo::class,
        ]);
    }
}
