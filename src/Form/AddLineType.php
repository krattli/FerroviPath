<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lineFile', FileType::class,[
                'label' => 'Fichier JSON de la ligne de métro','required'=>true,'attr'=>['class '=>'form-control mb-3']
            ])
            ->add('saveButton',SubmitType::class, [
                'label' => "Ajouter le fichier",
                'attr' => ['class' => 'form-control btn btn-primary mt-3 w-50', 'onclick'=>'confirm("Etes-vous sur d\'ajouter une ligne de métro ?")']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
