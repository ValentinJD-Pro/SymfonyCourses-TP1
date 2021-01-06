<?php

namespace App\Controller;

use App\Entity\Category;
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
            $category = $categoryRepo->findOneBy(array("Name"=> ucfirst( $type ) ));

            if(!$category) {
                $category=new Category();
                $category->setName($type);
                $em->persist($category);
            }
            if( $category && isset($data[$type]))
            {
                foreach($data[$type] as $dishArray)
                {
                    $dish = $dishRepo->findOneBy(
                        array("Name"=>$dishArray["name"])
                    );
                    if(!$dish) {
                        $dish= new Dish();
                    }
                    $dish->setName($dishArray["name"]);
                    $dish->setCalories($dishArray["calories"]);
                    dd($dishArray["price"]);
                    $dish->setPrice($dishArray["price"]);
                    $dish->setDescription($dishArray["text"]);
                    $dish->setSticky($dishArray["sticky"]);
                    $dish->setImage($dishArray["image"]);
                    $dish->setCategory($category);
                    dd($dish);

                    foreach($dishArray["allergens"] as $allergenArray)
                    {
                        $a = $allergenRepo->findOneBy(["name" => $allergenArray]);
                        if ($a === null) {
                            $a = new Allergen();
                            $a->setName($allergenArray);
                        }
                        $a->addDish($dish);
                        $em->persist($a);
                        $dish->addAllergen($a);
                    }
                    $em->persist($dish);
                    $em->flush();
                }
            }
        }
        return $this->redirectToRoute("admin");
    }

}

