<?php

namespace App\Form;

use App\Entity\HeartRate;
use App\Entity\ConnectedDevice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class HeartRateType extends AbstractType
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
            ->add('minHeartRate', NumberType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Min Heart Rate',
            ])
            ->add('maxHeartRate', NumberType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Max Heart Rate',
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
            'data_class' => HeartRate::class,
        ]);
    }
}
