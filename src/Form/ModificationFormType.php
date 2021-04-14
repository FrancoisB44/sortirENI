<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ModificationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('pseudo')


            ->add('nameUser')
            ->add('firstNameUser')
            ->add('phoneNumber')
            ->add('mail')
            ->add('campus',EntityType::class, [
        'class'  => Campus::class,
                'expanded' => false,
                'multiple' => false,
        ])

//            ->add('plainPassword', RepeatedType::class, [
//                'mapped' => false,
//                'constraints' => [
//                    new Length([
//                        'min' => 6,
//                        'minMessage' => 'Your password should be at least {{ limit }} characters',
//                        // max length allowed by Symfony for security reasons
//                        'max' => 4096,
//                    ]),
//                ],
//                'type' => PasswordType::class,
//                'invalid_message' => 'The password fields must match.',
//                'options' => ['attr' => ['class' => 'password-field']],
//                'required' => false,
//                'first_options'  => ['label' => ' '],
//                'second_options' => ['label' => ' '],
//            ])
            ->add('picture', FileType::class, [
                'label' => 'Image de profil',
                'mapped' => false,//pas associe a une entite
                'required' => false,
                'constraints' => [
                    new Image([ //new Image
                        'maxSize' => '10240k',
                    ])
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
