<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Personne;
use AppBundle\Form\PersonneType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonneController extends Controller
{
    /**
     * @Route("/personnes", name="personne_list")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $personnes = $em->getRepository("AppBundle:Personne")->findAll();
        return $this->render('AppBundle:Personne:index.html.twig',['personnes'=>$personnes]);
    }

    /**
     * @Route("/personnes/new", name="personne_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(PersonneType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           $personne = $form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($personne);
           $em->flush();

           $this->addFlash('success','Creation confirmé');

           return $this->redirectToRoute('personne_list');
        }
        return $this->render('AppBundle:Personne:create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/personnes/{id}/edit", name="personne_edit")
     */
    public function editAction(Request $request, Personne $personne)
    {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $personne = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();

            $this->addFlash('success','Edition confirmé');

            return $this->redirectToRoute('personne_list');
        }
        return $this->render('AppBundle:Personne:edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
