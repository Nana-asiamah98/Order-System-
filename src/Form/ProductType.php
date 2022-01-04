<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message'=> 'Enter a valid name'
                    ])
                ]
            ])
            ->add('amount',NumberType::class,[
                'required' => true,
                'scale' => 2,
                'constraints' => [
                    new NotBlank([
                        'message'=> 'Please enter a valid money amount.'
                    ]),
                    new Assert\Type([
                        'type' => 'numeric',
                        'message' => 'The value {{ value }} is not a valid {{ type }}.',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'csrf_protection'=> false,
            'allow_extra_fields' => true
        ]);
    }
}
