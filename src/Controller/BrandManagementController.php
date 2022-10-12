<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandManageType;
use App\Repository\BrandRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class BrandManagementController extends AbstractController
{
    /**
     * @Route("/brand/management", name="app_brand_management")
     */
    public function indexAction(BrandRepository $repo): Response
    {   $brand = $repo->FindAll();
        return $this->render('brand_management/index.html.twig', [
            'brand' => $brand
        ]);
    }

    /**
     * @Route("/addbrandmanage", name="addbrandmanage")
     */
    public function addBrandManageAction(Request $req, ManagerRegistry $res): Response
    {
        $brand = new Brand();

        $form = $this->createForm(BrandManageType::class, $brand);

        $form->handleRequest($req);
        $entity = $res->getManager();

        if($form->isSubmitted()&& $form->isValid()){
            $data = $form->getData();

            $brand->setBrandname($data->getBrandname());
            $brand->setBranddes($data->getBranddes());
            $brand->setStatus($data->getStatus());

            $entity->persist($brand);
            $entity->flush();

            return $this->redirectToRoute('app_brand_management')
            ;
        }
        return $this->render('brand_management/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("updatebrandmanage/{id}", name="updatebrandmanage")
     */
    public function updateBrandManageAction(BrandRepository $repo,int $id,Request $req, ManagerRegistry $res): Response
    {
        $brand = $repo->find($id);

        $form = $this->createForm(BrandManageType::class, $brand);

        $form->handleRequest($req);
        $entity = $res->getManager();

        if($form->isSubmitted()&& $form->isValid()){
            $data = $form->getData();

            $brand->setBrandname($data->getBrandname());
            $brand->setBranddes($data->getBranddes());
            $brand->setStatus($data->getStatus());

            $entity->persist($brand);
            $entity->flush();

            return $this->redirectToRoute('app_brand_management')
            ;
        }
        return $this->render('brand_management/update.html.twig',[
            'form' => $form->createView()
        ]);
    }
}