<?php

namespace App\Form;

use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Entity\Panier;
use App\Entity\Personnell;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reflivraison', \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                ['label'=>'Référence livraison',
                    'attr'=>array('readonly'=>true)
                    ])
            ->add('idpanier', EntityType::class, [
                'label'=>'Numéro panier',
                'class'=>Panier::class,
                'choice_label'=>'Idpanier',
                'placeholder'=>'Choisir un numéro de panier ',

            ])
            ->add('idlivreur', EntityType::class,[
                'label'=>'Matricule de livreur',
                'class'=>Livreur::class,
                'choice_label'=>'matricule',
                'placeholder'=>'Choisir un livreur',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
