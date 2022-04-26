<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Clientinfo;


class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('descriptionavis')
            ->add('idClient',EntityType::class,
                [
                    'class'=>Clientinfo::class,
                    'choice_label'=>'Nom'
                ])
            ->add('idblog',EntityType::class,
                [
                    'class'=>Blog::class,
                    'choice_label'=>'Titreblog'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
