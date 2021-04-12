<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Event;
use App\Entity\Place;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('nameEvent')
            ->add('StartDateTime', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            ->add('duration')
            ->add('registrationDeadLine', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            ->add('nbRegistrationsMax')
            ->add('infoEvent')
//            ->add('status')
            ->add('campus', EntityType::class, [
                'class' => 'App\Entity\Campus',
                'placeholder' => '--Sélectionnez un campus--'
            ])

            ->add('place', PlaceType::class)

//            ->add('place', EntityType::class, [
//                'class' => 'App\Entity\Place',
//                'placeholder' => '--Sélectionnez une ville--',
//                'mapped' => false
//            ])

//            ->add('place', Entity::class, array(
//                'class' => Place::class,
//                'label' => 'test',
//                'query_builder' => function (EntityRepository $er) use ($placeSearch) {
//                    return $er->createQueryBuilder('u')
//                        ->from('App:Place', 'u')
//                        ->where('u.namePlace = :e')
//                        ->setParameter('e', $placeSearch);
//                }
//            ))
        ;


//        $builder->get('place')->addEventListener(
//            FormEvents::POST_SET_DATA,
//            function (FormEvent $event) {
//                $form = $event->getData();
//                $event->getForm()->getParent()->add('place', EntityType::class, array(
//                    'class' => 'App\Entity\Place',
//                    'placeholder' => '--Sélectionnez un lieu--',
//                    'query_builder' => function (PlaceRepository $placeRepository) use ($form) {
//                    return $placeRepository->findAllPlaceByCity($form);
//                    }
//                ));
//            }
//        );


//            ->add('nameCity', EntityType::class, [
//                'class' => 'App\Entity\Place',
//                'placeholder' => '--Sélectionnez une ville--',
//                'mapped' => false
//            ])
//            ->add('namePlace', EntityType::class, [
//                'class' => 'App\Entity\Place',
//                'placeholder' => '--Sélectionnez un lieu--',
//                'mapped' => false
//            ])




    }




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}


//            ->add('place', Place::class, array(
//                'mapped' => false,
//                'class' => Place::class,
//                'property' => 'namePlace',
//                'empty_value' => '--Sélectionnez un lieu--',
//                'label' => 'Choix du lieu',
//                'multiple' => false,
//            ))

//            ->add('place', EntityType::class, array(
//                'class'=>'App\Entity\Place',
////                'choice_label'=>'street',
//                'expanded'=>false,
//                'multiple'=>false,
//            ))


//            ->add('place', EntityType::class, array(
//                'class'=>Place::class,
//
//                'query_builder'=> function(PlaceRepository $placeRepository) use ($rue) {
//                    return $placeRepository->quer
//                }
//            ))

