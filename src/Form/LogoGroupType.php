<?php

namespace OHMedia\LogoBundle\Form;

use OHMedia\LogoBundle\Entity\Logo;
use OHMedia\LogoBundle\Entity\LogoGroup;
use OHMedia\LogoBundle\Repository\LogoRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogoGroupType extends AbstractType
{
    public function __construct(private LogoRepository $logoRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $logoGroup = $options['data'];

        $builder->add('title');

        $logos = $this->logoRepository
            ->createQueryBuilder('l')
            ->orderBy('l.name', 'ASC')
            ->getQuery()
            ->getResult();

        if ($logos) {
            $builder->add('logos', EntityType::class, [
                'class' => Logo::class,
                'choices' => $logos,
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LogoGroup::class,
        ]);
    }
}
