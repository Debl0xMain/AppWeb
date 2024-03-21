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
use App\Repository\UsersRepository;
use Symfony\Component\userRepo\Core\userRepo;


class AdressFormType extends AbstractType
{
    private $userRepo;

    public function __construct(UsersRepository $userRepo){
        $this->userRepo = $userRepo;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentUser = $this->userRepo->getUser();

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
        // ->add('users', EntityType::class, [
        //     'class' => Users::class,
        //     'choice_label' => 'id',
        // ])
        ->add('user', EntityType::class, [
            'class' => Users::class,
            'choice_label' => 'id',
            'query_builder' => function (UsersRepository $er) use ($currentUser) {
                return $er->createQueryBuilder('u')
                    ->where('u.id = :userId')
                    ->setParameter('userId', $currentUser->getId());
            },
            'multiple' => false,
            'disabled' => true,
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
