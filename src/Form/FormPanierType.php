<?php

namespace App\Form;

use App\Entity\Clientinfo;
use App\Entity\Panier;
use App\Entity\Platt;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormPanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite')
            ->add('client' , TextType::class, [
                'attr' => ['class' => 'form-control'],'disabled'=>true
            ]
                )
            ->add('idplat',EntityType::class,[
                'class'=>Platt::class,
                'choice_label'=>'nomplat', 'placeholder'=>'Plat ....'

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
