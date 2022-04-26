<?php

namespace App\Form;

use App\Entity\Clientinfo;
use App\Entity\Lignecommande;
use App\Entity\Panier;
use App\Entity\Platt;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LignecommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('idplat',EntityType::class,[
                'class'=>Platt::class,
                'choice_label'=>'nomplat', 'placeholder'=>'choisir le plat'

            ])
            ->add('idpanier',EntityType::class,[
                'class'=>Panier::class,
                'choice_label'=>'numfacture', 'placeholder'=>'choisir la commande'])
            ->add('idClient',EntityType::class,[
                'class'=>Clientinfo::class,
                'choice_label'=>'nom','placeholder'=>'choisir le client'

            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lignecommande::class,
        ]);
    }
}
