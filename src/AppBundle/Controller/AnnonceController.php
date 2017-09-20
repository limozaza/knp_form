<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
}
