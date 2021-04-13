<?php


namespace App\Form;


use App\Data\SearchData;
use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Status;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class SearchType extends AbstractType
{
//    protected $user;
//    public function __construct(Security $security) {
//        $this->user = $security->getUser();
//    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('textSearch', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher une sortie'
                ]
            ])


            ->add('campusSearch', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => Campus::class,
                'placeholder' => 'Selectionnez un campus',
                'expanded' => false,
                'multiple' => false
            ))
            ->add('statusSearch', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => Status::class,
                'placeholder' => 'Selectionnez un etat',
                'expanded' => false,
                'multiple' => false
            ))
            ->add('dateStartSearch', DateTimeType::class, [
                'label' => false,
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            ->add('dateEndSearch', DateTimeType::class, [
                'label' => false,
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])

            ->add('userSearch', CheckboxType::class, array(
                'label' => 'Mes sorties',
                'required' => false,

//                'class' => User::class,
//                'placeholder' => 'Selectionnez un organisateur',
//                'expanded' => false,
//                'multiple' => false,
            ))

//            ->add('userSearch', EntityType::class, array(
//                'label' => 'Mes sorties',
//                'required' => false,
//                'class' => User::class,
////                'class' => User::class,
////                'placeholder' => 'Selectionnez un organisateur',
//                'expanded' => false,
//                'multiple' => false,
//            ))


            ->add('participantSearch', CheckboxType::class, array(
                'label' => 'Mes inscriptions',
                'required' => false,
                'mapped' => false
//                'class' => User::class,
//                'placeholder' => 'Selectionnez un organisateur',
//                'expanded' => false,
//                'multiple' => false,
            ))



        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}