<?php

namespace App\Form;

use App\Entity\Temperature;
use App\Entity\Sensor;
use App\Entity\ConnectedDevice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TemperatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('sensorId', TextType::class, ['attr' => ['class' => 'form-control']])
        ->add('connectedDevice', EntityType::class, [
            'class' => ConnectedDevice::class,
            'choice_label' => 'deviceId',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('minTemperature', NumberType::class, [
            'label' => 'Min Temperature',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('maxTemperature', NumberType::class, [
            'label' => 'Max Temperature',
            'attr' => ['class' => 'form-control'],
        ])

        ->add('isOn', CheckboxType::class, [
            'label' => 'Is On',
            'required' => false, // Le champ n'est pas obligatoire
            'attr' => ['class' => 'form-check-input'],
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Temperature::class,
        ]);
    }
}
