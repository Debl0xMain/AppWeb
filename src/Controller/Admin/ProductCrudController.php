<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('proName','Nom'),
            TextEditorField::new('proDesc','Description'),
            BooleanField::new('proActive','Actif')->hideValueWhenTrue(),
            AssociationField::new('subcategory',"Sous-Categorie")->setSortProperty('name'),
            MoneyField::new("proPriceHT","Price")->setCurrency('EUR'),
            TextField::new("proRef","Referance"),
            ImageField::new('proPictureName', 'Image')
            ->setUploadDir('public/assets/product')
            ->setBasePath('assets/product/')
            ->setUploadedFileNamePattern('[uuid].[extension]')
            ->setRequired($pageName !== Crud::PAGE_EDIT)
            ->setFormTypeOptions($pageName == Crud::PAGE_EDIT ? ['allow_delete' => false] : [])
        ];
    }

}
