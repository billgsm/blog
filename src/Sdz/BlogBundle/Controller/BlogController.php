<?php

namespace Sdz\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render('SdzBlogBundle:Blog:index.html.twig');
    }

    public function voirAction($id)
    {
        /**
         * How to send a mail
         */
        $mailer = $this->get('mailer');
        $message = \Swift_Message::newInstance()
          ->setSubject('Hello zéro !')
          ->setFrom('tutoriel@symfony.com')
          ->setTo('ga_bilou@hotmail.com')
          ->setBody('Coucou, voici un email que vous venez de recevoir !');

        $mailer->send($message);
        return new Response('Email successfully sent');
        //FIN-------------------

        //return $this->redirect( $this->generateUrl('sdzblog_accueil', array('page' => 2)) );
        $request = $this->getRequest();
        return $this->render('SdzBlogBundle:Blog:voir.html.twig', array('id' => $id));
    }

    public function voirSlugAction($slug, $annee, $format)
    {
        return new Response('slug -> '.$slug.' : annee -> '.$annee.' : format -> '.$format);
    }
}
