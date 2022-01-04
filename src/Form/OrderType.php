<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('total',MoneyType::class,[
                'required' => true,
                'scale' => 2,
                'constraints' => [
                    new NotBlank([
                        'message'=> 'Please enter a valid money amount.'
                    ]),
                ]
            ])
            ->add('discount', NumberType::class,[
                'required' => false,
                'scale' => 2,
                'constraints' => [
                    new NotBlank([
                        'message'=> 'Please enter a valid money amount.'
                    ]),
                ]
            ])
            ->add('state',TextType::class,[
                'required' => false,
            ])
            ->add('customer',EntityType::class,[
                'class' => User::class,
                'required' => true,
            ])
            ->add('product', CollectionType::class,[
                'entry_type' => ProductType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => true,
            ])
            ->add('shipping',CollectionType::class,[
                'entry_type' => ShippingType::class,
                'allow_add'=> true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
}
