<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Term;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentaireController extends Controller
{
    /**
     * @Route("/term/commentaire/{id}", name="term_commentaire")
     */
    public function ajouter(Request $request, $id)
    {

        $user = $this->getUser();
        $termRepo = $this->getDoctrine()->getRepository(Term::class);
        $term = $termRepo->find($id);

        $description = $request->query->get("commentaire");

        $commentaire = new Commentaire();

        $em = $this->getDoctrine()->getManager();
        $commentaire->setTerm($term);
        $commentaire->setUser($user);
        $commentaire->setDescription($description);
        $commentaire->setDateRegistred(new \DateTime());

        //sauvegarde
        $em->persist($commentaire);
        $em->flush();


        //message flash qui s'affichera sur la prochaine page
        $this->addFlash("success", "Votre commentaire a été ajouté");
        return $this->redirectToRoute("term_detail", ["id" => $id]);
    }




}
