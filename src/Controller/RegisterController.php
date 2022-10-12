<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function registerAction(Request $req, 
    UserPasswordHasherInterface $hasher,
    ManagerRegistry $reg, UserRepository $urepo): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);
        $entity = $reg->getManager();
        $error = 0;
        if($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            $userName = $data->getUsername();
            $checkSameUser = $urepo->checkSameUser($userName);
            
            if($checkSameUser[0]['count']==0){
            $user->setPassword($hasher->hashPassword($user,
            $form->get('password')->getData()));

            $user->setRoles(['ROLE_USER']);
            $user->setFullname($data->getFullname());
            $user->setGender($data->getGender());
            $user->setAddress($data->getAddress());
            $user->setTelephone($data->getTelephone());
            $user->setEmail($data->getEmail());
            $user->setBirthdate($data->getBirthdate());

            $entity->persist($user);
            $entity->flush();

            $cart = new Cart();
            $cart->setUser($user);

            $entity->persist($cart);
            $entity->flush();
            return $this->redirectToRoute('app_login');
            }
            else{
                $error = 1;
                return $this->render('register/index.html.twig', [
                    'form' => $form->createView(), 'error' => $error
                ]);
            }           
        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView(), 
            'error' => $error
        ]);
    }
}
