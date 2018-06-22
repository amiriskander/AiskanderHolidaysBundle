<?php

namespace Aiskander\HolidaysBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BulkHolidayType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder->add('holidays', CollectionType::class, [
            'entry_type' => HolidayType::class,
            'entry_options' => ['label' => true],
            'allow_add' => true,
            'prototype' => true,
            'prototype_data' => 'New Tag Placeholder',
        ]);*/

        /*$builder->add('holidays', ChoiceType::class, [
            'choices' => $options['data'],
            'multiple' => true,
            'expanded' => true
        ]);*/

        $builder->add('holidays', CollectionType::class, [
            'label' => 'Facilities',
            'entry_type' => HolidayType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'required' => false
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            // 'data_class' => 'Aiskander\HolidaysBundle\Entity\Holiday'
            'data_class' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'aiskander_holidaysbundle_bulk_holiday';
    }


}
