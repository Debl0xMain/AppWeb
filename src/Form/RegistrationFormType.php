<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    
        ->add('userEmail', EmailType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Adresse email manquante.']),
                new Email(['message' => 'Adresse email invalide.']),
            ],
            'label_attr' => [
                "class" =>"register_label"
                ],
            'attr'=> [
                    'class'=>'register_input my-2' 
                    ]
        ])
    
        ->add('Password', RepeatedType::class, [
            'label_attr' => [
                "class" =>"register_label"
                ],
            'attr'=> [
                    'class'=>'register_input my-2' 
            ],
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe ne correspondent pas.',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new Length([
                    'min' => 8,
                    'minMessage' => 'Le mot de passe doit faire au moins 8 caractères.',
                    'max' => 4096,
                    'maxMessage' => 'Le mot de passe ne doit pas dépasser 8 caractères.',
                ])
            ],
        ])
        ->add('userName', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'nom manquant.']),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Le nom doit faire au moins 3 caractères.',
                    'max' => 30,
                    'maxMessage' => 'Le nom ne doit pas dépasser 3 caractères.',
                ]),
                new Regex([
                    'pattern' => '~^[a-zA-Z0-9_.-]+$~',
                    'message' => 'Le nom ne doit contenir que des caractères alphanumériques non accentués et ".", "-" et "_".',
                ]),
            ],
            'label_attr' => [
                "class" =>"register_label"
                ],
            'attr'=> [
                    'class'=>'register_input my-2' 
                    ]
        ])
        ->add('userFristName', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'prenom manquant.']),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Le prenom doit faire au moins 3 caractères.',
                    'max' => 30,
                    'maxMessage' => 'Le prenom ne doit pas dépasser 3 caractères.',
                ]),
                new Regex([
                    'pattern' => '~^[a-zA-Z0-9_.-]+$~',
                    'message' => 'Le prenom ne doit contenir que des caractères alphanumériques non accentués et ".", "-" et "_".',
                ]),
                
            ],
            'label_attr' => [
                "class" =>"register_label"
                ],
            'attr'=> [
                    'class'=>'register_input my-2' 
                    ]
        ])
        ->add('UserPhone',TextType::class,[
            'label_attr' => [
                "class" =>"register_label"
                ],
            'attr'=> [
                    'class'=>'register_input my-2' 
                    ]
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
            'label_attr' => [
                "class" =>"rcheck"
                ],
        ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
