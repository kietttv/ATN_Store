<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProManageType;
use App\Form\UpdateProManageType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class ProManageController extends AbstractController
{
    /**
     * @Route("/promanage", name="app_pro_manage")
     */
    public function indexAction(ProductRepository $repo): Response
    {
        $product = $repo->indexProduct();
        return $this->render('pro_manage/index.html.twig', [
            'product' =>$product
        ]);
    }

    /**
     * @Route("/addpromanage", name="addpromanage")
     */
    public function addProManageAction(Request $req, ManagerRegistry $res): Response
    {
        $product = new Product();

        $form = $this->createForm(AddProManageType::class, $product);

        $form->handleRequest($req);
        $entity = $res->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $file = $form->get('Productimage')->getData()->getClientOriginalName();

            $product->setProductname($data->getProductname());
            $product->setPrice($data->getPrice());
            $product->setProductdes($data->getProductdes());
            $product->setProductdate($data->getProductdate());
            $product->setProductquantity($data->getProductquantity());
            $product->setProductimage($file);
            $product->setBrandid($data->getBrandid());
            $product->setStatus($data->getStatus());

            $entity->persist($product);
            $entity->flush();

            return $this->redirectToRoute('app_pro_manage', []);
        }
        return $this->render('pro_manage/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

        /**
     * @Route("/updatepromanage/{id}", name="updatepromanage")
     */
    public function updateProManageAction(Request $req, ManagerRegistry $res, int $id, ProductRepository $repo): Response
    {
        $product = $repo->find($id);

        $form = $this->createForm(UpdateProManageType::class, $product);

        $form->handleRequest($req);
        $entity = $res->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $file = $req->request->get('file');
                      

            $product->setProductname($data->getProductname());
            $product->setPrice($data->getPrice());
            $product->setProductdes($data->getProductdes());
            $product->setProductdate($data->getProductdate());
            $product->setProductquantity($data->getProductquantity());
            if($file){
                $product->setProductimage($file);
            }
            else{
                $oldimg = $req->request->get('oldimg');
                $product->setProductimage($oldimg);
            }
            $product->setBrandid($data->getBrandid());
            $product->setStatus($data->getStatus());

            $entity->persist($product);
            $entity->flush();

            return $this->redirectToRoute('app_pro_manage', []);

        }
        return $this->render('pro_manage/update.html.twig', [
            'form' => $form->createView(),
            'p' => $product
        ]);
    }

}
