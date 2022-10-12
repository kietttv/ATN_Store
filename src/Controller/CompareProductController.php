<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class CompareProductController extends AbstractController
{
    /**
     * @Route("/compare/product", name="app_compare_product")
     */
    public function compareAction(): Response
    {
        return $this->render('compare_product/index.html.twig', [
            'controller_name' => 'CompareProductController',
        ]);
    }
}
