<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\Dish1Type;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/dish")
 */
class DishController extends AbstractController
{
    /**
     * @Route("/", name="dish_index", methods={"GET"})
     */
    public function index(DishRepository $dishRepository): Response
    {
        return $this->render('dish/index.html.twig', [
            'dishes' => $dishRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dish_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dish = new Dish();
        $form = $this->createForm(Dish1Type::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dish);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                $form["Name"]->getData().' created !'
            );
            return $this->redirectToRoute('dish_index');
        }

        return $this->render('dish/new.html.twig', [
            'dish' => $dish,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dish_show", methods={"GET"})
     */
    public function show(Dish $dish): Response
    {
        return $this->render('dish/show.html.twig', [
            'dish' => $dish,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dish_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dish $dish): Response
    {
        $form = $this->createForm(Dish1Type::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                $form["Name"]->getData().' updated !'
            );
            return $this->redirectToRoute('dish_index');
        }

        return $this->render('dish/edit.html.twig', [
            'dish' => $dish,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dish_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dish $dish): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dish->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dish);
            $entityManager->flush();
        }
        $this->addFlash(
            'notice',
            $dish->getName().' deleted !'
        );
        return $this->redirectToRoute('dish_index');
    }


    function _availableCalories()
    {
        $calories = array ();
        for ( $i = 10 ; $i <= 300 ; $i += 10 )
            $calories [ $i ]= $i ;
        return $calories ;
    }
}
