<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Place;
use App\Repository\PlaceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nameEvent')
            ->add('StartDateTime')
            ->add('duration')
            ->add('registrationDeadLine')
            ->add('nbRegistrationsMax')
            ->add('infoEvent')
            ->add('status')
            ->add('campus')
//            ->add('place', EntityType::class, array(
//                'class'=>Place::class,
//
//                'query_builder'=> function(PlaceRepository $placeRepository) use ($rue) {
//                    return $placeRepository->quer
//                }
//            ))
            ->add('place', PlaceType::class)
//            ->add('place', EntityType::class, array(
//                'class'=>'App\Entity\Place',
//                'choice_label'=>'street',
//                'expanded'=>false,
//                'multiple'=>false,
//            ))
//            ->add('place', PlaceType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
