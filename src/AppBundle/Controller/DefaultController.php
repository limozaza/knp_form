<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
       /* $em = $this->getDoctrine()->getManager();

        $repoCategorie = $em->getRepository('AppBundle:Categorie');

        $annonce = new Annonce();
        $annonce->setName("Les socket io");

        $annonce->addCategory($repoCategorie->find(1));
        $annonce->addCategory($repoCategorie->find(2));
        $annonce->addCategory($repoCategorie->find(2));
        $em->persist($annonce);
        $em->flush();
*/
        return $this->render('default/index.html.twig');
    }
}
