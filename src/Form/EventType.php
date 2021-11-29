<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\GatheringComplement;
use App\Entity\GatheringComplementIncluded;
use App\Entity\GatheringComplementToBring;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                'label'          => 'Titre de l\'évènement',
                'label_attr'     => ['class' => 'event-form-label'],
                'attr'           => ['class' => 'event-form-input', 'placeholder' => 'HipHopCaribbeanSummerParty 2022'],
                'row_attr'       => ['class' => 'event-form-row']
            ])

            ->add('startingDate', DateTimeType::class, [
                'label'         => 'Début de la soirée',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' =>'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row'],
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])

            ->add('endingDate', DateTimeType::class, [
                'label'         => 'Fin de la soirée',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row'],
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])

            ->add('entrancePrice', IntegerType::class, [
                'label'         => 'Prix d\'entrée $€£',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            ->add('presentation', TextareaType::class, [
                'label'         => 'Présentation',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input', 'placeholder' => 'Donne nous un maximum d\'infos pour présenter et nous expliquer ta soirée ;)'],
                'row_attr'      => ['class' => 'event-form-row event-form-row-presentation']
            ])

            ->add('country', TextType::class, [
                'label'         => 'Pays',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input', 'placeholder' => 'France'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            ->add('city', TextType::class, [
                'label'         => 'Ville',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input', 'placeholder' => 'Paris'],
                'row_attr'      => ['class' => 'event-form-row']
            ])

            ->add('address', TextType::class, [
                'label'         => 'Adresse postale',
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
                'label'         => 'Fin des inscription',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row'],
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])

            ->add('limitedPlaces', IntegerType::class, [
                'label'         => 'Nombres de places limitées',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row'],
                // 'help'          => 'Choisir le nombre de places souhaités et disponibles aux personnes'
            ])

            // ->add('planner')

            ->add('gatheringComplementsIncluded', EntityType::class, [
                'class'         => GatheringComplementIncluded::class,
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
                'label'         => 'Ce qui est inclus',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row event-form-row-whats-included'],
                'expanded'      => true,
                'multiple'      => true,
                'mapped'        => false,
            ])

            ->add('gatheringComplementsToBring', EntityType::class, [
                'class'         => GatheringComplementToBring::class,
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
                'label'         => 'Ce que tu peux apporter',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row event-form-row-what-to-bring'],
                'expanded'      => true,
                'multiple'      => true,
                'mapped'        => false,
            ])

            ->add('eventPictures', FileType::class, [
                'multiple'      => true,
                'required'      => true,
                'mapped'        => false,
                'required'      => false,
                'label'         => 'Ajouter plus de photos',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row event-form-row-pictures'],
            ])

            ->add('eventCover', FileType::class, [
                'multiple'      => false,
                'required'      => true,
                'mapped'        => false,
                'required'      => false,
                'label'         => 'Ajoute une image de présentation',
                'label_attr'    => ['class' => 'event-form-label'],
                'attr'          => ['class' => 'event-form-input'],
                'row_attr'      => ['class' => 'event-form-row event-form-row-cover'],
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
