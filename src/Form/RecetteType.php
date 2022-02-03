<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Recette;
use App\Entity\Categorie;
use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('difficulte')
            ->add('prix')
            ->add('portions')
            ->add('histoire')
            ->add('region')
            ->add('astuce')
            ->add('tempsPreparation')
            ->add('tempsCuisson')
            ->add('tempsRepos')
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => true,
                'label' => 'Catégorie'

            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('Creer', SubmitType::class, [
                'label' => 'Créer',
                'attr' => [
                    'class' => 'btn btn-success',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
