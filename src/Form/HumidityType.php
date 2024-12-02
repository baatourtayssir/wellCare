<?php

namespace App\Form;

use App\Entity\Humidity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HumidityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sensorId')
            ->add('isOn')
            ->add('humidityLevel')
            ->add('connectedDevice')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Humidity::class,
        ]);
    }
}
