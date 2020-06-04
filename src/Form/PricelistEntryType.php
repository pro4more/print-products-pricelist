<?php

namespace App\Form;

use App\Entity\AvailableFormat;
use App\Entity\Material;
use App\Entity\PricelistEntry;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PricelistEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pages')
            ->add('copies')
            ->add('price')
            ->add('timeToProduce')
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
            ])
            ->add('format', EntityType::class, [
                'class' => AvailableFormat::class,
                'choice_label' => 'name',
            ])
            ->add('material', EntityType::class, [
                'class' => Material::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PricelistEntry::class,
        ]);
    }
}
