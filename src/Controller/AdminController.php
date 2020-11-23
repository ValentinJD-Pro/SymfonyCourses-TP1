<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Repository\AllergenRepository;
use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/import-dishes",name="import_dishes",methods={"GET"})
     */
    public function import_dishes(AllergenRepository $allergenRepo,DishRepository $dishRepo,CategoryRepository $categoryRepo):Response{
        $path="./../src/privateFiles/content.json";

        $em = $this->getDoctrine()->getManager();
        $json = file_get_contents($path);
        $data = json_decode($json,true);

        foreach([ "desserts","entrees","plats" ] as $type)
        {
            $category = $categoryRepo->findOneBy(array("name"=> ucfirst( $type ) ));
            // If category does not exist, create it.
            if( $category && isset( $data[$type] ) )
            {
                foreach($data[$type] as $dishArray)
                {
                    $dish = $dishRepo->findOneBy(
                        array("name"=>$dishArray["name"])
                    );
                    if(!$dish) {
                        $dish= new Dish(); // Insert
                    }
                    $dish->setName($dishArray["name"]);
                    $dish->setCategory($category);
                    //trucs ici
                    foreach($dishArray["allergens"] as $allergenArray)
                    {
                    // Update if exist, insert if not.
                    }
                    $em->persist($dish);
                    $em->flush();
                }
            }
        }
        return $this->redirectToRoute("admin");
    }

}

