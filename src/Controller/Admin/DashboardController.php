<?php

namespace App\Controller\Admin;

use App\Entity\Cagnotte;
use App\Entity\Category as EntityCategory;
use App\Entity\DonPhy;
use App\Entity\Event;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pfe');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Category', 'fas fa-list', EntityCategory::class, Category::class);
        yield MenuItem::linkToCrud('Cagnotte', 'fas fa-hand-holding-usd', Cagnotte::class);
        yield MenuItem::linkToCrud('DonPhy', 'fas fa-cubes', DonPhy::class);
        yield MenuItem::linkToCrud('Event', 'fas fa-calendar-check', Event::class);
        yield MenuItem::linkToCrud('User', 'fas fa-users', User::class);
    }
}
