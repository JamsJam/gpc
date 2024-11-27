<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Promos;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SearchMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PromosCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Promos::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchMode(SearchMode::ALL_TERMS)
            ->setPageTitle('detail', fn (Promos $promos) => (string) $promos->getTitre())
            ->setFormOptions([
                'attr' => ['data-controller' => 'cropper']
            ])
            ->setFormThemes(['admin/form.html.twig', '@EasyAdmin/crud/form_theme.html.twig'])
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('titre'),
            TextareaField::new('description')
                ->hideOnIndex()
            ,

            
            FormField::addPanel('Date'),
            FormField::addRow(),
            DateTimeField::new('beginAt','debut')->setColumns(6),
            DateTimeField::new('endAt','fin')->setColumns(6)
                ->hideOnIndex()
            ,

            FormField::addPanel('Prix'),
            FormField::addRow(),
            MoneyField::new('prix1', 'Prix Pack1')->setColumns(6)
                ->setCurrency('EUR')
                ->setNumDecimals(0)
                ->setStoredAsCents(true)
                ->hideOnIndex()
            ,
            MoneyField::new('prix2', 'Prix Pack2')->setColumns(6)
                ->setCurrency('EUR')
                ->setNumDecimals(0)
                ->setStoredAsCents(true)
                ->hideOnIndex()
            ,

            FormField::addPanel('Contenu'),
            FormField::addRow(),
            ArrayField::new('pack1', 'Contenu Pack1')->setColumns(6)
                ->hideOnIndex()
            ,
            ArrayField::new('pack2', 'Contenu Pack2')->setColumns(6)
                ->hideOnIndex()
            ,

            FormField::addPanel('Lien de paiement'),
            FormField::addRow(),
            UrlField::new('stripeLink1','Lien Stripe Pack 1')->setColumns(6)
                ->hideOnIndex()
            ,
            UrlField::new('stripeLink2','Lien Stripe Pack 2')->setColumns(6)
                ->hideOnIndex()
            ,
        
            FormField::addPanel('Image'),
            FormField::addRow(),FormField::addRow(),
            ImageField::new('image')
                ->setBasePath('/uploads/images/promotions')
                ->setUploadDir('public/uploads/images/promotions')
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
