<?php

namespace App\Form;

use App\Entity\PropertySearch;
use App\Entity\Option;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                  'placeholder' => 'Maximum budget'
                ]
            ])
            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                  'placeholder' => 'Minimum surface'
                ]
            ])
            ->add('options', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('address', null, [
                'label' => false,
                'required' => false
            ])
            ->add('distance', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    '10km' => 10,
                    '1000km' => 1000
                ]
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            /* do not use, better to use html tag
            ->add('submit', SubmitType::class, [
                'label' => 'Search'
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    /**
     * Block url params
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
