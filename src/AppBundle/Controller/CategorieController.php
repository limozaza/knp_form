<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repoCategorie = $em->getRepository('AppBundle:Categorie');

        $categories = $repoCategorie->findAll();

        return $this->render('AppBundle:Categorie:index.html.twig',['categories'=>$categories]);
    }

    /**
     * @Route("/categories/{id}", name="categorie")
     */
    public function showAction(Categorie $categorie)
    {
        return $this->render('AppBundle:Categorie:show.html.twig',['categorie'=>$categorie]);
    }
}
