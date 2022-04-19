<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Fournisseurs;
use App\Entity\Stocks;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class StocksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('noms',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Merci de saisir le nom'
                ]
            ])
            ->add('dateAjoutS', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('dateFinS', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])

            ->add('prixS',TextType::class,[
                'attr'=>[
                    'placeholder'=>"Merci de saisir le prix de l'unité"
                ]
            ])
            ->add('qtS',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Merci de saisir la quantité'
                ]
            ])
            ->add('idf',EntityType::class,
                [
                    'class'=>Fournisseurs::class,
                    'choice_label'=>'addf'

                ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stocks::class,
        ]);
    }
}
