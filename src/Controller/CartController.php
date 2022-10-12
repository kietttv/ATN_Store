<?php
namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartDetail;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\User;
use App\Repository\CartDetailRepository;
use App\Repository\CartRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart")
     */
    public function indexAction(CartRepository $cartrepo): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $a = $user->getId();
        $cart = $cartrepo->findOneBy(['user'=>$a]);

        $carts = $cartrepo->showCart($a, $cart); 
        $bc = $cartrepo->sumCart($a, $cart);
        $n = $bc[0]['total'];

        $error = 0;

        return $this->render("cart/index.html.twig",[
            'cart' =>$carts,
            'total'=>$n, 
            'error' =>$error
        ]);
    }

    /**
     * @Route("/addcart/{id}", name="addcart")
     */
    public function addCartAction( int $id, ManagerRegistry $res, ProductRepository $repo,
    CartRepository $cartrepo, CartDetailRepository $caderepo ): Response
    {
        $entity = $res->getManager();

        $cartdetail = new CartDetail();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user->getId();
        
        $cart = $cartrepo->findOneBy(['user'=>$user]);
        $ca = $caderepo->checkCartDetail($id, $cart);

        $product = $repo->find($id);
        
        if($ca[0]['count'] == 0){
            $cartdetail->setQuantity(1);
            $cartdetail->setCart($cart);
            $cartdetail->setProduct($product);

            $entity->persist($cartdetail);
            $entity->flush();
        }
        else {           
            $quantity = $ca[0]['quantity'] + 1;

            $id = $ca[0]['id'];
            $cartdetail = $caderepo->find($id);
            $cartdetail->setQuantity($quantity);
            $entity->persist($cartdetail);
            $entity->flush();
        } 
        
        return $this->redirectToRoute('home_page');
    }

    /**
     * @Route("/deletecart/{id}", name="deletecart")
     */
    public function deleteCartAction(int $id, ManagerRegistry $res, CartDetailRepository $caderepo
    , CartRepository $cartrepo): Response
    {
        $entity = $res->getManager();
        $cartdetail = $caderepo->find($id);

        $entity->remove($cartdetail);
        $entity->flush($cartdetail);

        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/updatecart/{id}", name="updatecart")
     */
    public function updateCartAction(int $id, ManagerRegistry $res, CartDetailRepository $caderepo
    , Request $req, CartRepository $cartrepo, ProductRepository $prorepo): Response
    {
        $quantity = $req->query->get('quantity');
        
        $proquan = $caderepo->checkUpdateCart($id);
        $quan = $proquan[0]['proquantity'];
        
        if($quantity <= $quan){
        $entity = $res->getManager();
        
        $cartdetail = $caderepo->find($id);
        $cartdetail->setQuantity($quantity);

        $entity->persist($cartdetail);
        $entity->flush();
        return $this->redirectToRoute('app_cart');
        }
        else{
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $a = $user->getId();
            $cart = $cartrepo->findOneBy(['user'=>$a]);
    
            $carts = $cartrepo->showCart($a, $cart); 
            $bc = $cartrepo->sumCart($a, $cart);
            $n = $bc[0]['total'];
    
            $error = 2;
    
            return $this->render("cart/index.html.twig",[
                'cart' =>$carts,
                'total'=>$n,
                'error' => $error
            ]);
        } 

    }

 /**
     * @Route("/order", name="order")
     */
    public function orderAction(CartRepository $cartrepo, ManagerRegistry $reg, 
    UserRepository $urepo, OrderRepository $orepo, ProductRepository $prorepo, CartDetailRepository $cdrepo): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $a = $user->getId();
        $addUser = $urepo->orderUser($user);
        $addusers = $addUser[0]['address'];

        $cart = $cartrepo->findOneBy(['user'=>$a]);

        $bc = $cartrepo->sumCart($a, $cart);
        $totals = $bc[0]['total'];
        $entity = $reg->getManager();

        $count = $cdrepo->countCart($cart);
        $counts = $count[0]['count'];

        $error = 0;

        if($counts > 0){
            $order = new Order();

            $order->setOrderdate(new \DateTime());
            $order->setAddress($addusers);
            $order->setPayment($totals);
            $order->setStatus(0);
            $order->setUser($user);
    
            $entity->persist($order);
            $entity->flush();
    
            $cart = $cdrepo->addCart($cart);
    
            $orderid = $orepo->maxOrder();
            $max = $orderid[0]['id'];
            $maxid = $orepo->find($max);
    
            for($i = 0; $i < $counts; $i++){
    
                $detail = new OrderDetail();
    
                $quantity = $cart[$i]['quantity'];
                $detail->setOderProQuan($quantity);
    
                $price = $cart[$i]['price'];
                $detail->setPrice($price);
    
                $total = $cart[$i]['total'];
                $detail->setTotal($total);
    
                $detail->setOrderid($maxid);
    
                $productid = $cart[$i]['proid'];
                $proid = $prorepo->find($productid);
                $detail->setProductid($proid);
    
                $entity->persist($detail);
                $entity->flush();
    
                $product = $prorepo->imageProduct($productid);
                $quanpro = $product[0]['quantity'];
    
                $pro = $prorepo->find($productid);
    
                $pro->setProductquantity($quanpro-$quantity);
    
                $entity->persist($pro);
                $entity->flush();
            }
    
            for($i = 0; $i < $counts; $i++){
                $productid = $cart[$i]['proid'];
                $proid = $prorepo->find($productid);
    
                $quantity = $cart[$i]['proquantity'] - $cart[$i]['quantity'];
    
                $proid->setProductquantity($quantity);
    
                $entity->persist($proid);
                $entity->flush();
            }
    
            for($i = 0; $i < $counts; $i++){
                $cartid = $cart[$i]['cdid'];
                $delete = $cdrepo->find($cartid);
                $entity->remove($delete);
                $entity->flush($delete);
            }
            
            return $this->redirectToRoute('home_page');

        }
        else{
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $a = $user->getId();
            $cart = $cartrepo->findOneBy(['user'=>$a]);
    
            $carts = $cartrepo->showCart($a, $cart); 
            $bc = $cartrepo->sumCart($a, $cart);
            $n = $bc[0]['total'];
    
            $error = 1;
    
            return $this->render("cart/index.html.twig",[
                'cart' =>$carts,
                'total'=>$n,
                'error' => $error
            ]);
        }
    }
}
