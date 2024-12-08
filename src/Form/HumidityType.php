<?php

namespace App\Form;

use App\Entity\Humidity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ConnectedDevice;
use Symfony\Component\Security\Core\Security;
use App\Repository\ConnectedDeviceRepository; 


class HumidityType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sensorId', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('connectedDevice', EntityType::class, [
                'class' => ConnectedDevice::class,
                'choice_label' => 'deviceId',
                'attr' => ['class' => 'form-control'],
                'query_builder' => function (ConnectedDeviceRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.user = :user')
                        ->setParameter('user', $this->security->getUser());
                },
            ])
            ->add('minHumidity', NumberType::class, [
                'label' => 'Min Humidity',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('maxHumidity', NumberType::class, [
                'label' => 'Max Humidity',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('isOn', CheckboxType::class, [
                'label' => 'Is On',
                'required' => false, // Le champ n'est pas obligatoire
                'attr' => ['class' => 'form-check-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Humidity::class,
        ]);
    }
}
