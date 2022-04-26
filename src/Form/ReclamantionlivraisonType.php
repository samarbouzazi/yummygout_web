<?php

namespace App\Form;

use App\Entity\Livraison;
use App\Entity\Reclamantionlivraison;
use http\Message;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReclamantionlivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reclamation',TextareaType::class,
                ['label'=>'Réclamation',
                ]

            )
            ->add('sujetrec', ChoiceType::class, ['label'=>'Sujet',
                'choices'=>[
                    'choisir le sujet'=>null,
                    'Probléme avec le livreur'=>'Probléme avec le livreur', 'Retard '=>'Retard', 'Probléme produit'=>'Probléme produit'
                ]])
            ->add('idLivraison', EntityType::class, [
                'label'=>'Référence livraison',
                'class'=>Livraison::class,
                'choice_label'=>'reflivraison',
                'placeholder'=>'Choisir le référence de livraison '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamantionlivraison::class,
        ]);
    }
}
