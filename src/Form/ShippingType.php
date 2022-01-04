<?php

namespace App\Form;

use App\Entity\ShippingDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ShippingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('method',TextType::class,[
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Submit a shipping method'
                    ])
                ]
            ])
            ->add('address', TextType::class,[
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please address'
                    ])
                ]
            ])
            ->add('postcode',NumberType::class,[
                'required' => true
            ])
            ->add('phoneNumber',TextType::class,[
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter phone number'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShippingDetails::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
}
