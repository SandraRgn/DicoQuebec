<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Term;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TermType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('term', null, ["label" => "Nom du terme *"])
            ->add('slug', null, ["label" => "Identifiant du terme *"])
            ->add('definition1', null, ["label" => "Définition principale *"])
            ->add('definition2', null, ["label" => "Définition secondaire"])
            ->add('example', null, ["label" => "Example"])
            ->add('translation', null, ["label" => "Traduction"])
            ->add('variations', null, ["label" => "Variations"])
            ->add('pronunciation', null, ["label" => "Prononciation"])
            ->add('origin', null, ["label" => "Origine"])
            ->add('categorie', EntityType::class, [
        "class" => Categorie::class,
        "label" => "Catégorie"])
            ->add('submit', SubmitType::class,["label" =>"Enregistrer"])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Term::class,
        ]);
    }
}
