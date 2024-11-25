<?php

namespace App\Controller\Admin;

use DateTime;
use DateTimeImmutable;
use App\Entity\Activites;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SearchMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActivitesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activites::class;
    }

    // /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnindex(),
            DateTimeField::new('createdAt')->onlyOnindex(),
            TextField::new('titre'),
            TextEditorField::new('description'),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchMode(SearchMode::ALL_TERMS)
            ->setPageTitle('detail', fn (Activites $activite) => (string) $activite->getTitre())
        ;
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
        
            ->add(Crud::PAGE_INDEX, Action::DETAIL)

        ;
    }

}
