<?php


namespace App\Form;


use App\Data\SearchData;
use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Status;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
//    private $id = 1;
//    public function __construct($id) {
//        $id = $this->id;
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

//            ->add('userSearch', EntityType::class, array(
//                'label' => 'Mes sorties',
//                'required' => false,
//                'class' => User::class,
////                'query_builder' => function (UserRepository $repo) use ($id) {
////                    return $repo->findBy($id);
////                },
//                'expanded' => false,
//                'multiple' => false,
//            ))

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