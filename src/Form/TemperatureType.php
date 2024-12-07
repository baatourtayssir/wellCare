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
use Symfony\Component\Security\Core\Security;

class TemperatureType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
        ->add('sensorId', TextType::class, ['attr' => ['class' => 'form-control']])
        ->add('connectedDevice', EntityType::class, [
            'class' => ConnectedDevice::class,
            'choice_label' => 'deviceId',
            'attr' => ['class' => 'form-control'],
            'query_builder' => function ($repository) use ($user) {
                return $repository->createQueryBuilder('cd')
                    ->where('cd.user = :user')
                    ->setParameter('user', $user);
            },
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
