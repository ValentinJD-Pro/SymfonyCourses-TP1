<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
        ]);
    }


    /**
     * @Route("/equipe", name="front_team", methods="GET")
     */
    public function equipe(UserRepository $ur): Response
    {
        return $this->render('front/equipe.html.twig', [
            'eqp'=>$ur->findAll(),
        ]);
    }

    /**
     * @Route("/carte", name="front_dishes", methods={"GET"})
     */
     public function carte(DishRepository $dr,CategoryRepository $cr):Response{
         $dishes=$dr->findAll();
         $categories=$cr->findAll();
         return $this->render('front/carte.html.twig',['dishes'=>$dishes,'categories'=>$categories]);
     }

     /**
      * @Route("/carte/{id}",name="front_dishes_category", methods={"GET"})
      */
     public function front_dishes_category(int $id,CategoryRepository $cr,DishRepository $dr):Response{
         $dishes=$dr->findAll();
         $cat=$cr->find($id);
         if(!$cat){
             throw $this->createNotFoundException('No category found for id : '.$id);
         }else{
             return $this->render('front/carte_category.html.twig',['category'=>$cat,'dishes'=>$dishes]);
         }
     }
}
