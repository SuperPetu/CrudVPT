<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Enter Name',
                'attr' => [
                    'placeholder' => 'Name'
                ]
            ])
            ->add('mail', TextType::class, [
                'label' => 'Enter Email',
                'attr' => [
                    'required' => true,
                    'placeholder' => 'Email'
                ]

            ])
            ->add('phone', TextType::class, [
                'label' => 'Enter Phone',
                'attr' => [
                    'placeholder' => 'Phone'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Select Type',
                'choices' => [
                    'Hotel' => 'hotel',
                    'Pista' => 'pista',
                    'Complemento' => 'complemento',
                ],
                'required' => true,
                'placeholder' => 'Selecciona tipo proveedor',
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Activo',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => [
                    'class' => 'btn btn-primary mt-2',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
