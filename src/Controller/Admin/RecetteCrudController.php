<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class RecetteCrudController extends AbstractCrudController
{
    public const RECETTE_BASE_PATH = 'upload/images/recettes';
    public const RECETTE_UPLOAD_DIR = 'public/upload/images/recettes';

    public static function getEntityFqcn(): string
    {
        return Recette::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('difficulte'),
            TimeField::new('tempsPreparation'),
            TimeField::new('tempsCuisson'),
            TimeField::new('tempsRepos'),
            TextField::new('prix'),
            IntegerField::new('portions'),
            TextField::new('histoire'),
            AssociationField::new('region'),
            DateTimeField::new('datePublication')->hideOnForm(),
            ImageField::new('nomImage')
                ->setBasePath(self::RECETTE_BASE_PATH)
                ->setUploadDir(self::RECETTE_UPLOAD_DIR)
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setSortable(false),
            TextField::new('astuce'),
            AssociationField::new('createur'),
            AssociationField::new('categories')
        ];
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Recette) return;
        $entityInstance->setDatePublication(new \DateTimeImmutable);
        parent::persistEntity($em, $entityInstance);
    }
}
