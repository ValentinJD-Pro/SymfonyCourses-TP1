<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use App\Services\RhService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BlockController extends AbstractController
{

    public function dayDishesAction(CategoryRepository $cr, DishRepository $dr, $max = 2, int $cat) : Response
    {
        $category = $cat ;
        $dishes = $dr->findStickies($category,$max);
        return $this->render('partials/day_dishes.html.twig', array('dishes' => $dishes));
    }

    public function team_today(RhService $rhService): Response
    {
        return $this->render('partials/team_today.html.twig', [
            'planning' => $rhService->getDayTeam()
        ]);
    }

}