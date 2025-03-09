<?php

namespace App\Form;

use Doctrine\DBAL\Types\JsonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lineFile', JsonType::class,[
                'label' => 'Fichier JSON de la ligne de métro','required'=>true,
            ])
            ->add('saveButton',SubmitType::class, [
                'label' => "Ajouter le fichier",
                'attr' => ['class' => 'btn btn-primary mt-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
