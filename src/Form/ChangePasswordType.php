<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Votre prénom'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Votre nom'
            ])
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Votre email'
            ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'Votre ancien mot de passe',
                'attr' => [
                    'placeholder' => 'Saisir votre ancien mot de passe'
                ]
            ])
            ->add('new_password',RepeatedType::class, [
                'mapped' =>false,
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe n\'est pas identique',
                'label' => 'Votre nouveau mot de passe',
                'required' =>true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => "Saisir votre mot de passe"
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Re saisir votre mot de passe"
                    ]
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Modifier'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
