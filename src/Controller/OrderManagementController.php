<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\UpdateOrderType;
use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class OrderManagementController extends AbstractController
{
    /**
     * @Route("/order/management", name="app_order_management")
     */
    public function indexAction(OrderRepository $repo): Response
    {   $order = $repo->indexOrder();
        return $this->render('order_management/index.html.twig', [
            'order' => $order
        ]);
    }

    
    /**
     * @Route("/orderdetail/{id}", name="orderdetail")
     */
    public function orderDetailAction(OrderDetailRepository $repo, int $id, OrderRepository $orepo): Response
    {
        $detail =$repo->showOrderDetail($id);
        $pay = $orepo->payOrder($id);
        $pays = $pay[0]['payment'];
        return $this->render('order_management/detail.html.twig', [
            'detail' => $detail,
            'payment' =>$pays
        ]);
    }

    /**
     * @Route("/updateorder/{id}", name="updateorder")
     */
    public function updateOrderAction(Request $req, ManagerRegistry $res, OrderRepository $orepo, int $id ): Response
    {
        $order = $orepo->find($id);

        $form = $this->createForm(UpdateOrderType::class, $order);

        $form->handleRequest($req);
        $entity = $res->getManager();

        if($form->isSubmitted()&& $form->isValid()){
            $data = $form->getData();

            $order->setAddress($data->getAddress());
            $order->setPayment($data->getPayment());
            $order->setStatus($data->getStatus());

            $time = null;
            if($data->getStatus() == 1){
                $time = new \DateTime();
                $order->setDeliverydate($time);
            }
            else{
                $order->setDeliverydate(null);
            }

            $entity->persist($order);
            $entity->flush($order);

            return $this->redirectToRoute('app_order_management');
        }
        return $this->render('order_management/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
