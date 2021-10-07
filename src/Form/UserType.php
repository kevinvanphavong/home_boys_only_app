<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
                // 'label_attr' => ['class' => 'userFormLabel'],
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input', ' placeholder' => 'john-doe@gmail.com'],
                // 'row_attr' => ['class' => 'row-userForm row-email']
                'row_attr' => ['class' => 'user-form-row']
            ])

            // ->add('roles')
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input', 'placeholder' => 'John'],
                'row_attr' => ['class' => 'user-form-row']
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input', 'placeholder' => 'Doe'],
                'row_attr' => ['class' => 'user-form-row']
            ])

            ->add('birthdate', DateType::class, [
                'label' => 'Birthdate',
                'label_attr' => ['class' => 'user-form-label'],
                'row_attr' => ['class' => 'user-form-row']
            ])

            ->add('phonenumber', TextType::class, [
                'label' => 'Phone number',
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input', 'placeholder' => '+33 645953115'],
                'row_attr' => ['class' => 'user-form-row']
            ])

            ->add('selfPresentation', TextareaType::class, [
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input', 'placeholder' => 'Describe yourself so people can get to know you ...'],
                'row_attr' => ['class' => 'user-form-row user-form-row-self-presentation']
            ])

            ->add('pictureProfile', FileType::class, [
                'label' => 'Profile picture',
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input'],
                'row_attr' => ['class' => 'user-form-row user-form-row-profile-picture'],
                'multiple' => false,
                'required' => false,
                'mapped' => false,
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Agree with the terms',
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input'],
                'row_attr' => ['class' => 'user-form-row user-form-row-agree-terms'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ]
            ])

            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'row_attr' => ['class' => 'user-form-row row-password'],
                'mapped' => false,
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input', 'placeholder' => '***********'],
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
