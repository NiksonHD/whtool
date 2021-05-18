<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('comment', TextType::class)
                ->add('sap1', TextType::class)
                ->add('sap2', TextType::class)
                ->add('sap3', TextType::class)
                ->add('sap4', TextType::class)
                ->add('sap5', TextType::class)
                ->add('sap6', TextType::class)
                ->add('sap7', TextType::class)
                ->add('sap8', TextType::class)
                ->add('q1', TextType::class)
                ->add('q2', TextType::class)
                ->add('q3', TextType::class)
                ->add('q4', TextType::class)
                ->add('q5', TextType::class)
                ->add('q6', TextType::class)
                ->add('q7', TextType::class)
                ->add('q8', TextType::class)
                
                ->add('sendEmail');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Lists'
        ));
    }


}
