<?php

namespace App\Form;

use App\Entity\SensorData;
use App\Entity\Sensor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;

class SensorDataType extends AbstractType
{
    private $security;

    // Injection du service Security
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('data', TextType::class, [
            'label' => 'Data',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('capturedAt', DateTimeType::class, [
            'label' => 'Captured At',
            'widget' => 'single_text',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('sensor', EntityType::class, [
            'class' => Sensor::class,
            'choice_label' => 'sensorId',
            'attr' => ['class' => 'form-control'],
            // Filtrer les capteurs par l'utilisateur connecté
            'query_builder' => function (EntityRepository $er) {
                // Récupérer l'utilisateur connecté
                $user = $this->security->getUser();

                // Filtrer les capteurs pour l'utilisateur connecté
                return $er->createQueryBuilder('s')
                    ->innerJoin('s.connectedDevice', 'cd')
                    ->where('cd.user = :user')
                    ->setParameter('user', $user);
            },
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SensorData::class,
        ]);
    }
}
