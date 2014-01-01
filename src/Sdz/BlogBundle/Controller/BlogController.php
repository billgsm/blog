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

        if( $page < 1) {
            throw $this->createNotFoundException('Page not found (page = '.$page.')');
        }

        $articles = $this->getDoctrine()
                         ->getManager()
                         ->getRepository('SdzBlogBundle:Article')
                         ->getArticles(3, $page);

        return $this->render('SdzBlogBundle:Blog:index.html.twig', array(
            'articles'   => $articles,
            'page'       => $page,
            'pageNumber' => ceil(count($articles)/3)
        ));
    }

    public function seeAction(Article $article)
    {
        $em = $this->getDoctrine()
                   ->getManager();

        $articleSkill_list = $em->getRepository('SdzBlogBundle:ArticleSkill')
                                ->findByArticle($article->getId());

        return $this->render('SdzBlogBundle:Blog:see.html.twig', array(
          'article' => $article,
          'articleSkill_list' => $articleSkill_list,
        ));
    }

    public function addAction()
    {
        $article = new Article();
        $form = $this->createFormBuilder($article)
                     ->add('date', 'date')
                     ->add('title', 'text')
                     ->add('content', 'textarea')
                     ->add('author', 'text')
                     ->add('publication', 'checkbox', array('required' => false))
                     ->getForm();

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('sdzblog_see', array(
                    'id' => $article->getId()
                )));
            }
        }

        return $this->render('SdzBlogBundle:Blog:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function modifyAction($id)
    {
        $article = $this->getDoctrine()
                        ->getRepository('Sdz\BlogBundle\Entity\Article')
                        ->find($id);

        $formBuilder = $this->createFormBuilder($article)
                            ->add('title', 'text')
                            ->add('content', 'textarea')
                            ->add('author', 'text')
                            ->getForm();


        return $this->render('SdzBlogBundle:Blog:modify.html.twig', array(
            'form' => $formBuilder->createView(),
            'article' => $article,
        ));
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

        if ($this->get('request')->getMethod() == 'POST') {
            $this->get('session')->getFlashBag()->add('info', 'Article deleted');

            return $this->redirect( $this->generateUrl('sdzblog_accueil') );
        }

        return $this->render('SdzBlogBundle:Blog:delete.html.twig', array(
            'article' => $article,
        ));
    }

    public function menuAction($number)
    {

        $list = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('SdzBlogBundle:Article')
                     ->findBy(
                         array(),
                         array('date' => 'desc'),
                         $number,
                         0
                     );

        return $this->render("SdzBlogBundle:Blog:menu.html.twig", array(
            'article_list' => $list,
        ));
    }
}
