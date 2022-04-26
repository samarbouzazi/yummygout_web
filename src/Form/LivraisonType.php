<?php

namespace App\Form;

use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Entity\Panier;
use App\Entity\Personnell;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('region', ChoiceType::class, ['label'=>'Région',
                'choices'=> [
                    'choisir la région' => null,
                   'Ariana Medina' =>'Ariana Medina',
                    'Ettadhamen	'=>'Ettadhamen	',
                    'Kalâat el-Andalous'=>'Kalâat el-Andalous',
                    'La Soukra'=>'La Soukra',
                    'Mnihla'=>'Mnihla',
                    'Raoued	'=>'Raoued	',
                    'Sidi Thabet'=>'Sidi Thabet',
                    'Bab El Bhar'=>'Bab El Bhar'	,
                    'Bab Souika	'=>'Bab Souika	',
                    'Carthage'=>'Carthage',
                    'Cité El Khadra	'=>'Cité El Khadra	',
                    'Djebel Jelloud'=>'Djebel Jelloud',
                    'El Kabaria	'=>'El Kabaria	',
                    'El Menzah'	=>'El Menzah'	,
                    'El Omrane'	=> 'El Omrane',
                    'El Omrane supérieur'=>'El Omrane supérieur',
                    'El Ouardia	'=>'El Ouardia	',
                    'Ettahrir'	=>'Ettahrir',
                    'Ezzouhour'=>'Ezzouhour',
                    'Hraïria'	=> 'Hraïria',
                    'La Goulette'=>'La Goulette',
                    'La Marsa'	=>'La Marsa',
                    'Le Bardo'=>'Le Bardo',
                    'Le Kram'	=>'Le Kram',
                    'Médina	'=>'Médina	',
                    'Séjoumi'=>'Séjoumi',
                    'Sidi El Béchir	'=>'Sidi El Béchir	',
                    'Sidi Hassine'=>'Sidi Hassine'
                ],
            ])
            ->add('rueliv', \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                ['label'=>'Adresse livraison']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
