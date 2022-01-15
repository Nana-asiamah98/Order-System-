<?php

namespace App\Form;

use App\Entity\Issues;
use App\Entity\IssuesInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description',TextType::class)
            ->add('orderIssue',ChoiceType::class,[
                'choices' => [
                    'Item Missing' => IssuesInterface::ITEM_MISSING,
                    'Item Damaged' => IssuesInterface::ITEM_DAMAGED,
                    'Item Mismatched' => IssuesInterface::ITEM_MISMATCHED,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Issues::class,
        ]);
    }
}
