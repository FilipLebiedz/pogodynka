<?php

namespace App\Form;

use App\Entity\Location;
use http\Env\Request;
use http\Env\Response;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Route;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null,[
                'attr'=>[
                    'placeholder'=>'Location name'
                ]
            ])
            ->add('country', CountryType::class, [
                'choices' =>[
                    'Poland' => 'PL',
                    'United States' => 'US',
                    'United Kingdom' => 'GB',
                    'Canada' => 'CA',
                    'India' => 'IN',
                    'Australia' => 'AU',
                    'Austria' => 'AT',
                    'Spain' => 'ES',
                    'Italia' => 'IT',
                    'Pakistan' => 'PK',
                    'France' => 'FR',
                ]
            ])
            ->add('latitude', NumberType::class,[
                'attr' => ['placeholder' => '-180 to 180']

                ])
            ->add('longitude', NumberType::class,[
                    'attr' => ['placeholder' => '-180 to 180']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}

