<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Event;
use App\Entity\Place;
use App\Repository\PlaceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('duration', DateTimeType::class, [
                'time_widget' => 'single_text'
            ])
            ->add('registrationDeadLine', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            ->add('nbRegistrationsMax')
            ->add('infoEvent')
//            ->add('status')
            ->add('campus')
            ->add('place', PlaceType::class)
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



        ;
    }




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
