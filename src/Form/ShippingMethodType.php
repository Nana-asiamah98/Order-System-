<?php

namespace App\Form;

use App\Entity\ShippingMethod;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShippingMethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shippingCompany',TextType::class,[
                'required' => true
            ])
            ->add('trackingNumber',TextType::class,[
                'required'=> true,
            ])
            ->add('documentPath',TextType::class,[
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShippingMethod::class,
            'csrf_protection' => true,
            'csrf_token_id' => 'shipping_method',
            'csrf_field_name' => '_token'
        ]);
    }
}
