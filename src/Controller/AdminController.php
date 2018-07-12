<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Term;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

    /**
     * @Route("/historique/", name="historique")
     */
    public function historique()
    {

        //permet de récupérer le repository
        $historiqueRepo = $this->getDoctrine()->getRepository(Historique::class);
        $historiques = $historiqueRepo->findAll();


        //return new Response("yo!");
        return $this->render("admin/historique.html.twig", ["historiques" => $historiques]);

    }

    /**
     * @Route("/term/restaurer/{id}", name="term_restaurer", requirements={"id": "\d+"})
     */
    public function restaurer(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $historique = $em->getRepository(Historique::class)->find($id);
        $term = new Term();
        $term->setTerm($historique->getTerm());
        $term->setSlug($historique->getSlug());
        $term->setDefinition1($historique->getDefinition1());
        $term->setDefinition2($historique->getDefinition2());
        $term->setCategorie($historique->getCategorie());
        $term->setExample($historique->getExample());
        $term->setTranslation($historique->getTranslation());
        $term->setVariations($historique->getVariations());
        $term->setPronunciation($historique->getPronunciation());
        $term->setCreatedDate($historique->getCreatedDate());
        $date = new \DateTime();
        $term->setEditedDate($date->getTimestamp());
        $term->setVotesCount($historique->getVotesCount());

        $em->remove($historique);

        $em->persist($term);
        $em->flush();

        $this->addFlash("success", "Le terme a bien été restauré");
        return $this->redirectToRoute("historique");

    }
}
