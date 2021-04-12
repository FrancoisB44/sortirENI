<?php


namespace App\Controller;


use App\Repository\CityRepository;
use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{

    /**
     * @Route("/demo",name="demo")
     */

    public function index(): Response
    {
        return $this->render('event/ajax.html.twig',[]);
    }

    //creation de la route qui va afficher une liste de ville
    /**
     * @Route ("/demo/villes/recherche", name="demo_city_search")
     */
    public function citySearch(PlaceRepository $placeRepository, Request $request): Response
    {
        $keyword=$request->query->get('keyword'); //le nom du parametre d url
       $results=  $placeRepository->searchCity($keyword); // methode inventee je passe mes mot cles en argumentss
        return $this->render("event/ajax_cities.html.twig",[
            "cities"=>$results
        ]);// renvoyer un morceaud  html avc les resultats dedans
    }


}