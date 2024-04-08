<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class SubCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubCategory::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('subName',"Nom"),
            AssociationField::new('categorys',"Categorie")->setSortProperty('name'),
            ImageField::new('subPictureName', 'Image')
            ->setUploadDir('public/assets/product')
            ->setBasePath('assets/product/')
            ->setUploadedFileNamePattern('[uuid].[extension]')
            ->setRequired($pageName !== Crud::PAGE_EDIT)
            ->setFormTypeOptions($pageName == Crud::PAGE_EDIT ? ['allow_delete' => false] : [])
        ];
    }

}
