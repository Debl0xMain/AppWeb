<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class AdressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adrNumber',TextType::class,[
            'label_attr' => [
                "class" =>" adress_label"
                ],
            'attr'=> [
                    'class'=>' adress_input ',
                    ]
        ])
            ->add('adrStreet',TextType::class,[
            'label_attr' => [
                "class" =>" adress_label"
                ],
            'attr'=> [
                    'class'=>' adress_input ',
                    ]
        ])
            ->add('adrZipCode',TextType::class,[
            'label_attr' => [
                "class" =>" adress_label"
                ],
            'attr'=> [
                    'class'=>' adress_input ' ,
                    ]
        ])
            ->add('adrCity',TextType::class,[
            'label_attr' => [
                "class" =>" adress_label"
                ],
            'attr'=> [
                    'class'=>' adress_input ' ,
                    ]
        ])
            ->add('adrAddInfo',TextType::class,[
            'label_attr' => [
                "class" =>" adress_label"
                ],
            'attr'=> [
                    'class'=>' adress_input ' ,
                    ]
        ])
        ->add('users', EntityType::class, [
            'class' => Users::class,
            'choice_label' => 'id',
        ])

        ->add('save', SubmitType::class, [
            'attr'=> 
           [
            'class'=>'btn btn-primary btn_modif_inscription' ],
            'label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
