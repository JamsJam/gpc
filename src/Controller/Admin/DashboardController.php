<?php

namespace App\Controller\Admin;

use App\Entity\Promos;
use App\Entity\Activites;
use App\Entity\Excursions;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        
        return $this->render('admin/dashboard.html.twig' ,[
            
        ]);
    }



    

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Guadeloupe Passion Caraïbe Dashboard')
            ->setFaviconPath('favicon/favicon.ico')
            ->setDefaultColorScheme('dark')
            ;
            
    }

    public function configureAssets(): Assets
    {
        return Assets::new()

            // you can also import multiple entries
            // it's equivalent to calling {{ importmap(['app', 'admin']) }}
            ->addAssetMapperEntry('app')
            ->addHtmlContentToBody('<script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelector("main").classList.add("easy-admin-main");
            });
        </script>')
        ;
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            
        ;
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Retour au site', 'fa ...', 'app_home');
        yield MenuItem::section('Gestion voyage');
        yield MenuItem::linkToCrud('Activités', 'fas fa-list', Activites::class);
        yield MenuItem::linkToCrud('Excursions', 'fas fa-list', Excursions::class);
        yield MenuItem::section('Gestion Commercial');
        yield MenuItem::linkToCrud('Offres promotionnelle', 'fas fa-list', Promos::class);
        yield MenuItem::section('Gestion Administrateur');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', Activites::class);
        // yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
    }


    
}
