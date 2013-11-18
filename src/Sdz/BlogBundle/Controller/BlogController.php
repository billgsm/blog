<?php

namespace Sdz\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function indexAction($page)
    {
      if( $page < 1) {
        throw $this->createNotFoundException('Page not found (page = '.$page.')');
      }
      return $this->render('SdzBlogBundle:Blog:index.html.twig');
    }

    public function seeAction($id)
    {
        /**
         * How to send a mail
         */
        // $this->get('service_name')
        /*
        $mailer = $this->get('mailer');
        $message = \Swift_Message::newInstance()
          ->setSubject('Hello zéro !')
          ->setFrom('tutoriel@symfony.com')
          ->setTo('ga_bilou@hotmail.com')
          ->setBody('Coucou, voici un email que vous venez de recevoir !');

        $mailer->send($message);
        return new Response('Email successfully sent');*/
        //FIN-------------------

        //return $this->redirect( $this->generateUrl('sdzblog_accueil', array('page' => 2)) );
        //$request = $this->getRequest();
      return $this->render('SdzBlogBundle:Blog:see.html.twig', array(
        'id' => $id
      ));
    }

    public function addAction($slug, $annee, $format)
    {
      if( $this->get('request')->getMethod() == 'POST' ) {
        $this->get('session')->getFlashBag()->add('notice', 'article saved');
        return $this->redirect( $this->generateUrl('sdzblog_voir', array('id' => 5)) );
      }
      return $this->render('SdzBlogBundle:Blog:add.html.twig');
    }

    public function modifyAction($id)
    {
      return $this->render('SdzBlogBundle:Blog:modify.html.twig');
    }

    public function deleteAction($id)
    {
      return $this->render('SdzBlogBundle:Blog:delete.html.twig', array(
        'id' => $id
        ));
    }
}
