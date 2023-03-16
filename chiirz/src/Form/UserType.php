<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pseudo', TextType::class, [
            'label' => 'Pseudonyme',
        ])
        ->add('email', TextType::class, [
            'label' => 'Adresse email',
        ])
        ->add('password', TextType::class, [
            'label' => 'Mot de passe',
        ])
        ->add('register_date', TextType::class, [
            'label' => 'Date d\'inscription',
        ])
        ->add('url_pp', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
