<?php


namespace App\Form;


use App\Data\SearchData;
use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

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

//            ->add('campusSearch', EntityType::class, array(
//                'class' => Campus::class,
//                'choice_label' => function($campus) {
//                    return $campus->getNameCampus();
//                },
//                'choice_value'=>'campusSearch'
//            ))


            ->add('campusSearch', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Campus::class,
                'expanded' => false,
                'multiple' => true
            ])
            ->add('statusSearch', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Status::class,
                'expanded' => false,
                'multiple' => true
            ])
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