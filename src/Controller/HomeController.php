<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePassType;
use App\Form\ProfileType;
use App\Form\UserType;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

date_default_timezone_set('Asia/Ho_Chi_Minh');

class HomeController extends AbstractController
{
    /**
     * @Route("/homepage", name="home_page")
     */
    public function indexAction(ProductRepository $repo, CartRepository $cartrepo): Response
    {
        $product = $repo->indexProductHome();
        return $this->render("home_page/index.html.twig",[
            'product' =>$product
        ]);
    }
     /**
     * @Route("/homepage/{id}", name="productDetail")
     */
    public function productDetailAction(ProductRepository $repo, int $id): Response
    {
        $product = $repo->find($id);
        return $this->render("home_page/productdetail.html.twig",[
            'product' =>$product
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(ProductRepository $repo, Request $req): Response
    {
        $mess = $req->query->get('search');
        $product = $repo->findProductByName($mess);
        $count = $repo->countProductByName($mess);
        $counts = $count[0]['count']; 
        return $this->render("home_page/search.html.twig",[
            'product' =>$product,
            'count'=>$counts,
            'mess'=>$mess
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profileAction(Request $req, ManagerRegistry $reg, UserRepository $repo): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user->getId();
        $user = $repo->find($user);
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($req);
        $entity = $reg->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();

            $user->setFullname($data->getFullname());
            $user->setGender($data->getGender());
            $user->setAddress($data->getAddress());
            $user->setTelephone($data->getTelephone());
            $user->setEmail($data->getEmail());
            $user->setBirthdate($data->getBirthdate());

            $entity->persist($user);
            $entity->flush();

            return $this->redirectToRoute('home_page');
        }

        return $this->render('home_page/profile.html.twig', [
            'form' => $form->createView()
        ]);       
    }

    /**
     * @Route("/compare", name="app_compare")
     */
    public function compareAction(ProductRepository $repo, CartRepository $cartRepo, Request $req): Response
    {
        $a = $req->query->get('proA');
        $b = $req->query->get('proB');
        $compareProduct = $repo->compareProducts($a, $b);
        return $this->render('compare_product/index.html.twig', [
        'product' => $compareProduct
        ]);
    }

    /**
     * @Route("/confirmpassword", name="confirmpassword")
     */
    public function confirmPasswordAction(): Response
    {
        return $this->render('home_page/confirmpassword.htm.twig');
    }

    /**
     * @Route("/temp", name="temp", methods="POST")
     */
    public function tempAction(Request $req, 
    UserPasswordHasherInterface $hasher,
    ManagerRegistry $reg, UserRepository $urepo): Response
    {
        $user = $this->getUser();
        $oldpwd = $req->request->get('password');
        $a = $hasher->isPasswordValid($user,$oldpwd);
        if($a == true){
            return $this->redirectToRoute('changepassword');
        }
        else{
            return $this->redirectToRoute('confirmpassword');
        }
    }
    /**
     * @Route("/changepassword", name="changepassword")
     */
    public function changePasswordAction(Request $req, 
    UserPasswordHasherInterface $hasher,
    ManagerRegistry $reg, UserRepository $urepo ): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user->getId();
        $user = $urepo->find($user);
        $form = $this->createForm(ChangePassType::class, $user);
        $form->handleRequest($req);
        $entity = $reg->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword($hasher->hashPassword($user,
            $form->get('password')->getData()));

            $entity->persist($user);
            $entity->flush();

            return $this->redirectToRoute('home_page');
        }
        
        return $this->render('home_page/changepass.html.twig', [
            'form' => $form->createView()
        ]);  
    }

}
