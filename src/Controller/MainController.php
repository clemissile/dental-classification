<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/liste", name="liste")
     */
    public function list()
    {
        return $this->render('main/list.html.twig');
    }

    /**
     * @Route("/upload", name="upload")
     */
    public function upload()
    {
        return $this->render('main/upload.html.twig');
    }
}
