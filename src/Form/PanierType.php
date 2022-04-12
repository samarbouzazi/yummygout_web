<?php

namespace App\Form;

use App\Entity\Clientinfo;
use App\Entity\Panier;
use App\Entity\Platt;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite')
            ->add('numfacture', \Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label'=>'numéro de la commande',
                'attr'=>array('readonly'=>true)
            ])
            ->add('rue')
            ->add('etat')
            ->add('delegation')
            ->add('idplat',EntityType::class,[
                'class'=>Platt::class,
                'choice_label'=>'Nomplat', 'placeholder'=>'choisir le plat'

            ])
            ->add('idClient',EntityType::class,[
                'class'=>Clientinfo::class,
                'choice_label'=>'nom','placeholder'=>'choisir le client'

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Panier::class,
        ]);
    }
}
