<?php

namespace App\Form;

use App\Entity\Partygoer;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // l'id de chaque label est un combiné du nom de l'entité + nom de la propriété du label
        // ex : pour le label "email"       => l'id sera "user_email"
        // ex : pour le label "agreeTerms"  => l'id sera "user_agreeTerms"

        // label        -> le label
        // label_attr   -> les attributs du label
        // attr         -> les attributs du widget / input
        // row_attr     -> les attributs de la div qui enveloppe label + widget

        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input', ' placeholder' => 'john-doe@gmail.com'],
                'row_attr' => ['class' => 'user-form-row']
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Veuillez à accepter nos conditions d\'utilisations',
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input'],
                'row_attr' => ['class' => 'user-form-row user-form-row-agree-terms'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les termines de conditions générales',
                    ]),
                ]
            ])

            // ->add('password', PasswordType::class, [
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label'     => 'Mot de passe',
                'row_attr' => ['class' => 'user-form-row row-password'],
                'mapped' => false,
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input', 'placeholder' => '***********', 'autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
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
