<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Term;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {


        //permet de récupérer le repository
        $termRepo = $this->getDoctrine()->getRepository(Term::class);
        $terms = $termRepo->findBy(
            array(),
            array('term' => 'ASC'));


        $term = $terms[array_rand($terms)];

        $cateRepo = $this->getDoctrine()->getRepository(Categorie::class);
        $categories = $cateRepo->findAll();

        //return new Response("yo!");
        return $this->render("default/accueil.html.twig", ["term" =>$term, "terms" => $terms, "categories" =>$categories]);

    }

    /**
     * @Route("/mentions/", name="mentions")
     */
    public function mentions()
    {

        return $this->render("default/mentions.html.twig");

    }

    /**
     * @Route("/propos/", name="propos")
     */
    public function propos()
    {

        return $this->render("default/propos.html.twig");

    }

}
