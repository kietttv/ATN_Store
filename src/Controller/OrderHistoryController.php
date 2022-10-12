<?php

namespace App\Controller;

use App\Repository\OrderDetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class OrderHistoryController extends AbstractController
{
    /**
     * @Route("/order/history", name="app_order_history")
     */
    public function indexAction(OrderDetailRepository $repo): Response
    {
        $user = $this->getUser();
        $history = $repo->historyOrder($user);
        return $this->render('order_history/index.html.twig', [
            'history' => $history
        ]);
    }
}
