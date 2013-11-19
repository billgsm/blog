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

    public function addAction()
    {
      return $this->render('SdzBlogBundle:Blog:add.html.twig');
    }

    public function modifyAction($id)
    {
      return $this->render('SdzBlogBundle:Blog:modify.html.twig');
    }

    public function deleteAction($id)
    {
      return $this->render('SdzBlogBundle:Blog:delete.html.twig', array(
        'id' => $id,
        'name' => '<h2>bilel</h2>',
        ));
    }

    public function menuAction()
    {
      $list = array(
        array('id' => 2, 'title' => 'My last weekend!'),
        array('id' => 5, 'title' => 'Release of Symfony2.1'),
        array('id' => 9, 'title' => 'Small test'),
      );
      return $this->render("SdzBlogBundle:Blog:menu.html.twig", array(
        'article_list' => $list,
      ));
    }
}
