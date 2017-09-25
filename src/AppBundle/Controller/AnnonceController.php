<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Categorie;
use AppBundle\Form\AnnonceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnnonceController extends Controller
{
    /**
     * @Route("/annonces", name="annonces")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repoAnnonce = $em->getRepository('AppBundle:Annonce');

        $annonces = $repoAnnonce->findAll();

        return $this->render('AppBundle:Annonce:index.html.twig',['annonces'=>$annonces]);
    }

    /**
     * @Route("/annonces/{id}", name="annonce")
     */
    public function showAction(Annonce $annonce)
    {
        return $this->render('AppBundle:Annonce:show.html.twig',['annonce'=>$annonce]);
    }
    /**
     * @Route("/annonces/{id}/categorie/{cat_id}", name="annonce_categorie_remove")
     * @Method("DELETE")
     */
    public function removeCategorieDannnonce(Annonce $annonce, $cat_id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat  = $em->getRepository('AppBundle:Categorie')->find($cat_id);

        if(!$annonce){
            throw $this->createNotFoundException('Annonce not found');
        }

        if(!$cat){
            throw $this->createNotFoundException('Categorie not found');
        }
        $annonce->removeCategory($cat);
        $em->persist($annonce);
        $em->flush();
        return new Response(null,Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/annonce/new", name="annonce_new")
     */
    public function newAnnonceAction(Request $request)
    {
        $form = $this->createForm(AnnonceType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $annonce = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('success','Creation confirmé');

            return $this->redirectToRoute('annonces');
        }
        return $this->render('AppBundle:Annonce:create.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/annonces/edit/{id}", name="annonce_edit")
     */
    public function editAction(Request $request,Annonce $annonce)
    {
        $form = $this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $annonce = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('success','Creation confirmé');

            return $this->redirectToRoute('annonces');
        }
        return $this->render('AppBundle:Annonce:edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
