<?php

namespace App\Form;

use App\Entity\ConnectedDevice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ConnectedDeviceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('deviceId', TypeTextType::class, ['attr' => ['class' => 'form-control']])
        ->add('name', TypeTextType::class, ['attr' => ['class' => 'form-control']])
        ->add('isOn', CheckboxType::class, [
            'label' => 'Is On',
            'required' => false, // Le champ n'est pas obligatoire
            'attr' => [
                'class' => 'form-check-input', // Ajout de classes CSS Bootstrap
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConnectedDevice::class,
        ]);
    }
}
