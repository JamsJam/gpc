<?php

namespace App\Controller\Admin\Crud;

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
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ActivitesCrudController extends AbstractCrudController
{

    public function __construct(
        // public CropperInterface $cropper
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
            //! ==================== not on form
            
            
            DateTimeField::new('createdAt', 'Ajouté le')
                ->setFormat('dd/MM/yyyy  HH:mm:ss')
                ->hideOnForm()
                ->setSortable(true)
                ,
            BooleanField::new('isPublic','Visible')
                ->onlyOnIndex()
            ,
            
            //!====================== on form

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
        
        //! ==========================  Index page
            ->add(Crud::PAGE_INDEX, Action::DETAIL)


            //? ===== label index actions
            ->update(Crud::PAGE_INDEX, Action::DETAIL,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Details');
            })
            ->update(Crud::PAGE_INDEX, Action::NEW,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Ajouter');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Supprimer');
            })

        //! ==========================  Details page

            // ->add(Crud::PAGE_DETAIL, Action::INDEX)


            //? ===== label detail actions
            ->update(Crud::PAGE_DETAIL, Action::EDIT,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Modifier');
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_DETAIL, Action::INDEX,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Retour');
            })


            -> reorder(Crud::PAGE_DETAIL, [Action::DELETE,Action::INDEX,Action::EDIT])

        //! ==========================  New page
            ->add(Crud::PAGE_NEW, Action::INDEX)

            ->update(Crud::PAGE_NEW, Action::INDEX, function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Annuler');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Enregistrer et continuer');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Enregistrer');
            })


        //! ==========================  Edit page
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_EDIT, Action::DELETE)



            ->update(Crud::PAGE_EDIT, Action::INDEX,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Annuler');
            })
            ->update(Crud::PAGE_EDIT, Action::DELETE,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Valider');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Valider et quitter');
            })
            // ->update(Crud::PAGE_INDEX, Action::DELETE,function (Action $action) {
            //     return $action->setIcon('fa fa-file-alt')->setLabel('Supprimer');
            // })
            ;
    }


}
