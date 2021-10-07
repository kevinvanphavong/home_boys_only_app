<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\GatheringComplement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'          => 'Title of your event',
                'label_attr'     => ['class' => 'event-form-label'],
                'attr'           => ['class' => 'event-form-input', 'placeholder' => 'HipHopCaribbeanSummerParty 2022'],
                'row_attr'       => ['class' => 'event-form-row']
            ])

            ->add('startingDate', DateTimeType::class, [
                'label'         => 'Start-date of your party',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            ->add('endingDate', DateTimeType::class, [
                'label'         => 'End-date of your party',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            ->add('entrancePrice', IntegerType::class, [
                'label'         => 'Entrance price $€£',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            ->add('presentation', TextareaType::class, [
                'label'         => 'Presentation',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input', 'placeholder' => 'Give a maximum informations to introduce and explain your party ;)'],
                'row_attr'      => ['class' => 'event-form-row event-form-row-presentation']
            ])

            ->add('country', TextType::class, [
                'label'         => 'Country',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input', 'placeholder' => 'France'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            ->add('city', TextType::class, [
                'label'         => 'City',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input', 'placeholder' => 'Paris'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            ->add('address', TextType::class, [
                'label'         => 'Address',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input', 'placeholder' => '17 Boulevard des arômes'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            // ->add('accomodation', TextType::class, [
            //     'label'         => 'Type of accomodation',
            //     'label_attr'    => ['class' => 'event-form-label'],
            //     'attr'          => ['class' => 'event-form-input', 'placeholder' => 'Appartement, Maison, Villa, Extérieur, Bidonville'],
            //     'row_attr'      => ['class' => 'event-form-row']
            // ])

            ->add('endOfRegistrations', DateTimeType::class, [
                'label'         => 'End of regsitrations',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            ->add('limitedPlaces', IntegerType::class, [
                'label'         => 'Limited places',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            // ->add('planner')

            ->add('complementsIncluded', EntityType::class, [
                'class'         => GatheringComplement::class,
                'choice_label'  => function ($complement) {
                    return $complement->getIcon();
                },
                'choice_value'  => function ($complement) {
                    return $complement->getName();
                },
                'choice_attr'   => function ($complement) {
                    return [
                        'title'  =>  $complement->getName(),
                    ];
                },
                'label'         => 'What\'s included',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row event-form-row-whats-included'],
                'expanded'      => true,
                'multiple'      => true,
                'mapped'        => false,
            ])

            ->add('complementsToBring', EntityType::class, [
                'mapped'        => false,
                'class'         => GatheringComplement::class,
                'choice_label'  => function ($complement) {
                    return $complement->getIcon();
                },
                'choice_value'  => function ($complement) {
                    return $complement->getName();
                },
                'choice_attr'   => function ($complement) {
                    return [
                        'title'  =>  $complement->getName(),
                    ];
                },
                'label'         => 'What to bring',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row event-form-row-what-to-bring'],
                'expanded'      => true,
                'multiple'      => true,
            ])

            ->add('submit', SubmitType::class, [
                'label'         => 'Save it',        
                'attr'          => ['class' => 'btn btn-success'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
