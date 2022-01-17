<?php

namespace App\Form;

use DateTime;
use App\Entity\Partygoer;
use App\Entity\ProfileImage;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormTypeInterface;

class PartygoerType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label'         => 'Prénom',
                'label_attr'    => ['class' => 'user-form-label'],
                'attr'          => ['class' => 'user-form-input'],
                'row_attr'      => ['class' => 'user-form-row'],
            ])
            ->add('lastname', TextType::class, [
                'label'         => 'Nom',
                'label_attr'    => ['class' => 'user-form-label'],
                'attr'          => ['class' => 'user-form-input'],
                'row_attr'      => ['class' => 'user-form-row'],
            ])
            ->add('birthdate', BirthdayType:: class, [
                'label'         => 'Date de naissance',
                'label_attr'    => ['class' => 'user-form-label'],
                'attr'          => ['class' => 'user-form-input'],
                'row_attr'      => ['class' => 'user-form-row'],
            ])
            ->add('phone', NumberType::class, [
                'label'         => 'Numéro de téléphone',
                'label_attr'    => ['class' => 'user-form-label'],
                'attr'          => ['class' => 'user-form-input'],
                'row_attr'      => ['class' => 'user-form-row'],
            ])
            ->add('presentation', TextareaType::class, [
                'label'         => 'Et si tu nous disais ce qui t\'amène ici ;)',
                'label_attr'    => ['class' => 'user-form-label'],
                'attr'          => ['class' => 'user-form-input'],
                'row_attr'      => ['class' => 'user-form-row user-form-row-self-presentation'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => ['class' => 'user-form-label'],
                'attr' => ['class' => 'user-form-input', ' placeholder' => 'john-doe@gmail.com'],
                'row_attr' => ['class' => 'user-form-row'],
                'mapped' => false
            ])
            ->add('profilePicture', FileType::class, [
                'required'      => false,
                'mapped'        => false,
                'by_reference'  => false,
                'constraints' => [
                    new Image([
                        'maxSizeMessage' => 'Troppp lourd pelo'
                    ])
                    ],
                'label'         => 'Ajoute votre photo de profil',
                'label_attr'    => ['class' => 'user-form-label'],
                'attr'          => ['class' => 'user-form-input user-form-input-profile-picture'],
                'row_attr'      => ['class' => 'user-form-row user-form-row-profile-picture'],
            ])
            // ->add('lifeInterests', TextType::class, [
            //     'label' => 'Centre d\'intérêts',
            //     'label_attr' => ['class' => 'user-form-label'],
            //     'attr' => ['class' => 'user-form-input user-form-input-life-interests'],
            //     'row_attr' => ['class' => 'user-form-row'],
            //     'required'      => false,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partygoer::class,
        ]);
    }
}
