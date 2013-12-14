<?php

namespace Sdz\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sdz\BlogBundle\Entity\Article;
use Sdz\BlogBundle\Entity\Image;
use Sdz\BlogBundle\Entity\ArticleSkill;

class BlogController extends Controller
{
    public function indexAction($page)
    {

        $antispam = $this->get('sdz_blog.antispam');
        $text = "test@test.fr, test@test.fr, test@test.fr";
        if ($antispam->isSpam($text)) {
            throw new \Exception('Your message has been detected as a spam !');
        }
      if( $page < 1) {
        throw $this->createNotFoundException('Page not found (page = '.$page.')');
      }
      
      $articles = array(
        array(
          'id'      => 1,
          'title'   => 'My weekend at Phi Island !',
          'author'  => 'winzou',
          'content' => 'This weekend was good. Blabla...',
          'date'    => new \Datetime(),
        ),
        array(
          'id'      => 2,
          'title'   => 'Singapor national day repetition',
          'author'  => 'winzou',
          'content' => 'will be ready for the day j soooooooooon.',
          'date'    => new \Datetime(),
        ),
        array(
          'id'      => 3,
          'title'   => 'revenus up',
          'author'  => 'winzou',
          'content' => '+500% over a year',
          'date'    => new \Datetime(),
        ),
      );

      return $this->render('SdzBlogBundle:Blog:index.html.twig', array(
        'articles' => $articles,
      ));
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

        //$request = $this->getRequest();
        
        $em = $this->getDoctrine()
                   ->getManager();
                           
        $repository = $em->getRepository('SdzBlogBundle:Article');

        $article = $repository->find($id);

        if( $article === null ) {
            throw $this->createNotFoundException('Article[id='.$id.'] does not exist.');
        }

        $articleSkill_list = $em->getRepository('SdzBlogBundle:ArticleSkill')
                                ->findByArticle($article->getId());

        return $this->render('SdzBlogBundle:Blog:see.html.twig', array(
          'article' => $article,
          'articleSkill_list' => $articleSkill_list,
        ));
    }

    public function addAction()
    {
        // Creation of Article entity
        $article = new Article();
        $article->setTitle('Mon dernier weekend');
        $article->setContent("it was really cool and we had fun.");
        $article->setAuthor('Bibi');

        // Creation of Image entity
        $image = new Image();
        $image->setUrl('http://uploads.siteduzero.com/icones/478001_479000/478657.png');
        $image->setAlt('Symfony2 logo');

        // Link the image to the article
        $article->setImage($image);

        // Get the EntityManager
        $em = $this->getDoctrine()->getManager();

        // Persist the entity
        $em->persist($article);

        // Flush all what has been persisted before
        $em->flush();

        $skills_list = $em->getRepository('SdzBlogBundle:Skill')
                          ->findAll();

        foreach($skills_list as $i => $skill)
        {
            $skillArticle[$i] = new ArticleSkill;

            $skillArticle[$i]->setArticle($article);
            $skillArticle[$i]->setSkill($skill);
            $skillArticle[$i]->setLevel('Expert');

            $em->persist($skillArticle[$i]);
        }

        $em->flush();

        if ($this->getRequest()->getMethod() == "POST") {
            $this->get('session')->getFlashBag()->add('info', 'Article has been saved');
            return $this->redirect( $this->generateUrl('sdzblog_see', array('id' => $article->getId())) );
        }
        return $this->render('SdzBlogBundle:Blog:add.html.twig');
    }

    public function modifyAction($id)
    {
        $em = $this->getDoctrine()
                   ->getManager();

        $article = $em->getRepository('SdzBlogBundle:Article')
                      ->find($id);

        if ($article === null) {
            throw $this->createNotFoundException('Article [id='.$id.'] not found.');
        }

        $categoies_list = $em->getRepository('SdzBlogBundle:Category')
                             ->findAll();

        foreach($categories_list as $category)
        {
            $article->addCategory($category);
        }

        $em->flush();

        return new Response('OK');
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
                   ->getManager();

        $article = $em->getRepository('SdzBlogBundle:Article')
                      ->find($id);

        if ($article === null) {
            throw $this->createNotFoundException('Article [id='.$id.'] not found');
        }

        $categories_list = $em->getRepository('SdzBlogBundle:Category')
                              ->findAll();

        foreach($categoies_list as $category)
        {
            $article->removeCategoy($category);
        }

        $em->flush();

        return new Response('OK');
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
