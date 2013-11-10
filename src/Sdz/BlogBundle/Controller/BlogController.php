<?php

namespace Sdz\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function indexAction()
    {
        // Simple response containing characters
        //return new response("<h1>Hello World</h1>");
        return $this->render('SdzBlogBundle:Blog:index.html.twig');
    }

    public function voirAction($id)
    {
        return new Response('Affichage de l\'article d\'id: '.$id);
        //return $this->render('SdzBlogBundle:Blog:index_bye.html.twig');
    }

    public function voirSlugAction($slug, $annee, $format)
    {
        return new Response('slug -> '.$slug.' : annee -> '.$annee.' : format -> '.$format);
        //return $this->render('SdzBlogBundle:Blog:index_bye.html.twig');
    }
}
