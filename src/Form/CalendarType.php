<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\Livreur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('start', DateTimeType::class,[
                'date_widget'=>'single_text'])
            ->add('end', DateTimeType::class,[
                'date_widget'=>'single_text'])
            ->add('description')
            ->add('allday')
            ->add('backgroundcolor', ColorType::class)
            ->add('bordercolor', ColorType::class)
            ->add('textcolor', ColorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}
