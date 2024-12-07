<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Excursions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SearchMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExcursionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Excursions::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            // ->addAssetMapperEntry('app')
        ;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchMode(SearchMode::ALL_TERMS)
            ->setPageTitle('detail', fn (Excursions $excursion) => (string) $excursion->getTitre())
            ->setFormOptions([
                'attr' => ['data-controller' => 'cropper']
            ])
            ->setFormThemes(['admin/form.html.twig', '@EasyAdmin/crud/form_theme.html.twig'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnindex()
                ->setSortable(true)
                ,
            DateTimeField::new('createdAt')
                ->onlyOnindex()
                ->setSortable(true)
                ,
            TextField::new('titre')
                ->setSortable(true)
                ,
            TextEditorField::new('description'),
            
            FormField::addPanel('Image'),

            ImageField::new('image')
                ->setBasePath('/uploads/images/excursions')
                ->setUploadDir('/uploads/images/excursions')
                ->setUploadedFileNamePattern('[timestamp]-[randomhash].[extension]')
                ->setFormTypeOptions([
                    'attr' =>[
                        'require'=> false,

                        "data-action"=>"change->cropper#loadImage"
                        ]
                ]),

            FormField::addPanel('Aperçu image'),
            TextField::new('crop', '')
                ->setFormTypeOptions([
                    'mapped'=>'false',
                    'block_name' => 'crop_image'
                ])
                ->onlyOnForms(),
        ];
    }



    public function configureActions(Actions $actions): Actions
    {
        return $actions
        
            ->add(Crud::PAGE_INDEX, Action::DETAIL)

        ;
    }
}
