<?php

namespace App\Form;

use App\Entity\Forcast;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForcastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateType::class,[
                'widget' => 'single_text',
            ])
            ->add('temperature',NumberType::class,[
                'attr' => [
                    'placeholder'=>'-100 to 100'
                ]
            ])
            ->add('humidity',NumberType::class,[
                'attr' => [
                    'placeholder'=>'0 to 100'
                ]
            ])
            ->add('perceived_temperature',NumberType::class,[
                'attr' => [
                    'placeholder'=>'-180 to 180'
                ]
            ])
            ->add('wind',NumberType::class,[
                'attr' => [
                    'placeholder'=>'0 or more'
                ]
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forcast::class,
        ]);
    }
}
