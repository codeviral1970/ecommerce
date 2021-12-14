<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserAccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/compte/modification-mot-de-passed', name: 'user_account_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $success = null;
        $danger = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dump($form->getData());
            $old_pwd = $form->get('old_password')->getData();
           
           if ($encoder->isPasswordValid($user, $old_pwd)) {
               $new_pwd = $form->get('new_password')->getData();
               $password = $encoder->hashPassword($user, $new_pwd);

               $user->setPassword($password);
               $this->entityManager->flush();
               $success = 'Votre mot de passe à été modifier';
           } else {
               $danger = 'Votre ancien mot de passe n\'est pas bon';
           }
        }

        return $this->render('user_account/password.html.twig', [
            'form' => $form->createView(),
            'success' => $success,
            'danger' => $danger
        ]);
    }
}
