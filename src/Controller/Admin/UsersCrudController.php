<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

class UsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('userEmail','Mail'),
            ChoiceField::new('roles','Role')->setChoices([
                'Commercial' => 'ROLE_COM',
                'Particulier'=> 'ROLE_USER',
                'Proffesionel' => 'ROLE_PRO',
            ])
            ->allowMultipleChoices(),
            TextField::new('userName','Name'),
            TextField::new('userFristName','Second Name'),
            TextField::new('userRef','Ref'),
            TextField::new('userCoefficient','Coef'),
            TextField::new('userPhone','Phone'),
            TextField::new('userCompanyName','Company Name'),
            TextField::new('userCompanySiret','Company Siret'),
        ];
    }

}
