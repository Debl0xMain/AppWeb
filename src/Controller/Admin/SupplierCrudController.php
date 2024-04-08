<?php

namespace App\Controller\Admin;

use App\Entity\Supplier;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SupplierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Supplier::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('supName','Name'),
            TextField::new('supRef',"Ref"),
            NumberField::new('supType','Type'),
            TextField::new('supPhone',"Phone"),
            TextField::new('supMail',"Mail"),
            TextField::new('supAddress','Adress'),
            NumberField::new('supCodePostal',"City Code"),
            TextField::new('supNumberAddress','Number'),
            TextField::new('supVille',"City"),
        ];
    }
}
