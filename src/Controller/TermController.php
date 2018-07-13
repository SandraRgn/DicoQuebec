<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Historique;
use App\Entity\Term;
use App\Form\TermType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TermController extends Controller
{
    /**
     * @Route("/term/detail/{id}", name="term_detail", requirements={"id": "\d+"})
     */
    public function detail($id){
        $termRepo = $this->getDoctrine()->getRepository(Term::class);
        $term = $termRepo->find($id);

        $terms = $termRepo->findBy(
            array(),
            array('term' => 'ASC'));

        $cateRepo = $this->getDoctrine()->getRepository(Categorie::class);
        $categories = $cateRepo->findAll();

        return $this->render("term/detail.html.twig", ["term" => $term, "terms" => $terms, "categories" =>$categories]);

    }

    /**
     * @Route("/term/ajouter", name="term_ajout")
     */
    public function ajouter(Request $request)
    {

        $term = new Term();
        $termForm = $this->createForm(TermType::class, $term);

            //pour traiter le formulaire
        $termForm->handleRequest($request);
            if ($termForm->isSubmitted() && $termForm->isValid()) {
                //retourne une instance de l'entity manager
                $em = $this->getDoctrine()->getManager();
                //on remplit le champ date car il n'est pas dans le formulaire
                $date = new \DateTime();
                $term->setCreatedDate($date->getTimestamp());
                $term->setVotesCount(0);

                //sauvegarde
                $em->persist($term);
                $em->flush();


                //message flash qui s'affichera sur la prochaine page
                $this->addFlash("success", "Votre terme a été ajouté");
                return $this->redirectToRoute("term_detail", ["id" => $term->getId()]);
            }
       /* else{
            //message flash qui s'affichera sur la prochaine page
            $this->addFlash("danger", "Vous devez vous connecter !");
            return $this->redirectToRoute("login");
        }*/


        return $this->render('term/ajouter.html.twig', ["termForm" => $termForm->createView()
        ]);
    }

    /**
     * @Route("/term/modifier/{id}", name="term_modifier", requirements={"id": "\d+"})
     */
    public function modifier(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $term= $em->getRepository(Term::class)->find($id);
        $termForm = $this->createForm(TermType::class, $term);
        //pour traiter le formulaire
        $termForm->handleRequest($request);
        if($termForm->isSubmitted() && $termForm->isValid()) {

            if (!$id) {
                throw $this->createNotFoundException(
                    'pas de terme correspondant à cet ID ' . $id
                );
            }

            $em->flush();

            $this->addFlash("success", "Le terme a bien été modifié");
            return $this->redirectToRoute("term_detail", ["id" => $term->getId()]);
        }
        return $this->render('term/modifier.html.twig', ["termForm" => $termForm->createView()
        ]);
    }

    /**
     * @Route("/term/supprimer/{id}", name="term_supprimer", requirements={"id": "\d+"})
     */
    public function supprimer(Request $request, $id)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha("6LcOD2MUAAAAAJ6Pu6S9OgedcBGhjdU_yjslRfV3");
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
        $commentaireSuppression = $request->request->get("commentaireSuppression");
        $user = $this->getUser();


        if (!$resp->isSuccess()) {
            // Do something if the submit wasn't valid ! Use the message to show something
            $message = "The reCAPTCHA wasn't entered correctly. Go back and try it again.";
        }else{
            $em = $this->getDoctrine()->getManager();
            $term = $em->getRepository(Term::class)->find($id);
            $historique = new Historique();
            $historique->setUser($user);
            $historique->setTerm($term->getTerm());
            $historique->setSlug($term->getSlug());
            $historique->setDefinition1($term->getDefinition1());
            $historique->setDefinition2($term->getDefinition2());
            $historique->setCategorie($term->getCategorie());
            $historique->setExample($term->getExample());
            $historique->setTranslation($term->getTranslation());
            $historique->setVariations($term->getVariations());
            $historique->setPronunciation($term->getPronunciation());
            $historique->setCreatedDate($term->getCreatedDate());
            $date = new \DateTime();
            $historique->setEditedDate($date->getTimestamp());
            $historique->setVotesCount($term->getVotesCount());
            $historique->setCommentaire($commentaireSuppression);

            $em->remove($term);

            $em->persist($historique);
            $em->flush();

            $this->addFlash("success", "Le terme a bien été supprimé");
            return $this->redirectToRoute("accueil");
        }


        return $this->render('term/supprimer.html.twig', ["id" =>$id]);
    }


    /**
     * @Route("/term/recherche/", name="recherche")
     */
    public function recherche(Request $request){

        //récupère l'éventuel mot clé
        $keyword = $request->query->get("q");

        //permet de récupérer le repository
        $termRepo = $this->getDoctrine()->getRepository(Term::class);
        $terms = $termRepo->findHomeTerms($keyword);

        $termsListe = $termRepo->findBy(
            array(),
            array('term' => 'ASC'));


        //return new Response("yo!");
        return $this->render("term/recherche.html.twig", ["terms" =>$terms, "termsListe" =>$termsListe]);
    }

    /**
     * @Route("/term/aimer/{id}", name="term_aimer")
     */
    public function aimer($id){
        $termRepo = $this->getDoctrine()->getRepository(Term::class);
        $term = $termRepo->find($id);
        $user = $this->getUser();
        if($user){
            $em = $this->getDoctrine()->getManager();
            $term->setVotesCount($term->getVotesCount()+1);
            $user->addTerm($term);

            $em->persist($user);
            $em->persist($term);
            $em->flush();

            $this->addFlash("success", "J'aime ajouté");
            return $this->redirectToRoute("term_detail", ["id" => $term->getId()]);
        }else{
            //message flash qui s'affichera sur la prochaine page
            $this->addFlash("danger", "Vous devez vous connecter !");
            return $this->redirectToRoute("login");
        }



    }

    /**
     * @Route("/term/dislike/{id}", name="term_dislike", requirements={"id": "\d+"})
     */
    public function dislike($id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $term= $em->getRepository(Term::class)->find($id);
        $term->setVotesCount($term->getVotesCount()-1);
        $term->removeUsers($user);
        $em->persist($term);
        $em->flush();

        $this->addFlash("success", "J'aime retiré");
        return $this->redirectToRoute("term_detail", ["id" => $term->getId()]);
    }

    /**
     * @Route("/term/coupcoeur", name="coupcoeur")
     */
    public function coupCoeur()
    {
        $termRepo = $this->getDoctrine()->getRepository(Term::class);
        $terms = $termRepo->findTermLike();

        return $this->render("term/coupcoeur.html.twig", ["terms" => $terms]);


    }

    /**
     * @Route("/term/categorie/{id}", name="categorie", requirements={"id": "\d+"})
     */
    public function termCategorie($id)
    {

        //permet de récupérer le repository
        $termRepo = $this->getDoctrine()->getRepository(Term::class);
        $terms = $termRepo->findTermsCategorie($id);

        $listeTerms = $termRepo->findBy(
            array(),
            array('term' => 'ASC'));

        $cateRepo = $this->getDoctrine()->getRepository(Categorie::class);
        $categories = $cateRepo->findAll();



        //return new Response("yo!");
        return $this->render("term/rechercheCategorie.html.twig", ["terms" => $terms, "categories" => $categories, "listeTerms" => $listeTerms]);
    }



}
