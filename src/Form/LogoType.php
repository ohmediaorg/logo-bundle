<?php

namespace OHMedia\LogoBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use OHMedia\FileBundle\Form\Type\FileEntityType;
use OHMedia\LogoBundle\Entity\Logo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogoType extends AbstractType
{
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

        $builder->add('groups', EntityType::class, [
            'class' => LogoGroup::class,
            'query_builder' => function (EntityRepository $er): QueryBuilder {
                return $er->createQueryBuilder('lg')
                    ->orderBy('lg.title', 'ASC');
            },
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Logo::class,
        ]);
    }
}
