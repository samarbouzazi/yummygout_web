<?php

namespace App\Form;

use App\Entity\Clientinfo;
use App\Entity\Paiement;
use App\Entity\Panier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etatpaiement', ChoiceType::class, [
                'choices'  => [
                    'non' => 'non',
                    'oui' => 'oui',
                ],
            ]
            )

            ->add('idpanier',EntityType::class,[
            'class'=>Panier::class,
            'choice_label'=>'idpanier', 'placeholder'=>'choisir le numéro commande'
    ])
            ->add('idClient',EntityType::class,[
        'class'=>Clientinfo::class,
        'choice_label'=>'nom', 'placeholder'=>'choisir le CLIENT'

    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
