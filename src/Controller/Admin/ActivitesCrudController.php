<?php

namespace App\Controller\Admin;

use DateTime;
use DateTimeImmutable;
use App\Entity\Activites;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\UX\Cropperjs\Factory\CropperInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SearchMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActivitesCrudController extends AbstractCrudController
{

    public function __construct(
        public CropperInterface $cropper
    ){}

    public static function getEntityFqcn(): string
    {
        return Activites::class;
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
            ->setPageTitle('detail', fn (Activites $activite) => (string) $activite->getTitre())
            ->setFormOptions([
                'attr' => ['data-controller' => 'cropper']
            ])
            ->setFormThemes(['admin/form.html.twig', '@EasyAdmin/crud/form_theme.html.twig'])
        ;
    }

    // /*
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
                ->setBasePath('/uploads/images/activites')
                ->setUploadDir('public/uploads/images/activites')
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
