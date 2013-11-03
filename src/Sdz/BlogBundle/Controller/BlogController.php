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

    public function index_byeAction()
    {
        return $this->render('SdzBlogBundle:Blog:index_bye.html.twig');
    }
}
