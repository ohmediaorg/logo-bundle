<?php

namespace OHMedia\LogoBundle\Form;

use OHMedia\FileBundle\Form\Type\FileEntityType;
use OHMedia\LogoBundle\Entity\Logo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name');

        $builder->add('url', UrlType::class, [
            'required' => false,
            'label' => 'URL',
        ]);

        $builder->add('image', FileEntityType::class, [
            'image' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Logo::class,
        ]);
    }
}
