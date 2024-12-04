<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Votre adresse email",
                'attr' => [
                    'placeholder' => "Indiquer votre adresse email"
                ]
            ]) // en indiquant EmailType, on est obligé d'inclure un @ dans le champs
            // ->add('roles') , je le commente pour ne pas que l'utilisateur puisse choisir lui même son rôle
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min'=> 4,
                        'max' => 30
                    ])
                    ],
                'first_options'  => [
                    'label' => 'Votre mot de passe',
                    'attr' => [
                        'placeholder' => "Choississez votre mot de passe"
                    ], 
                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                    'placeholder' => "Confirmez votre mot de passe"
                    ]
                ], 
                'mapped' => false, // false pour lui dire de ne pas essayer de faire le lien entre l'entité et le formulaire sur ce champs car dans mon entité user le seul champs password s'appelle password et non plainPassword
            ])
            ->add('firstname', TextType::class, [
                'label' => "Votre prénom",
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 30
                    ])
                    ],
                'attr' => [
                    'placeholder' => "Indiquez votre prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Votre nom",
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 30
                    ])
                ],
                'attr' => [
                    'placeholder' => "Indiquez votre nom"
                ]
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Valider",
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]) // premier paramètre le nom et en deuxieme le type de champs/élément
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity([
                    'entityClass' => User::class,
                    'fields' => 'email'
                ])
            ],
            'data_class' => User::class,
        ]);
    }
}
