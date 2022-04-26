<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Classroom;
use App\Entity\Platt;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descplat')
            ->add('nomplat')
            ->add('image',FileType::class, array('data_class' => null))

            ->add('prixPlat')
            ->add('qPlat')

            //->add('stock')
            ->add('stock', ChoiceType::class, [
                'choices' => [
                    'active' => true,
                    'inactive' => false
                ]
            ])
            ->add('idcatt',EntityType::class,
                [
                    'class'=>Categorie::class,
                    'choice_label'=>'Nomcat'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Platt::class,
        ]);
    }
}
