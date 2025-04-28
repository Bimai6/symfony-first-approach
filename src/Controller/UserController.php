<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;

final class UserController extends AbstractController
{
    #[Route('/user/create_user', name: 'create_user')]
    public function createUser(EntityManagerInterface $entityManager): Response{
        $user = new User();
        $user->setName('Javi');
        $user->setSurname('Ariza Rosales');
        $user->setAge(21);
        $user->setDni('12345678A');

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response('Saved new user with id ' . $user->getId());
    }

    #[Route('user/form', name:'app_form'), ]
    public function processForm(Request $request, EntityManagerInterface $entityManager): Response {
        
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager->persist($user);

            $entityManager->flush();

            return $this->redirectToRoute('user_success');
        }

        return $this->render('user/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('user/confirmed', name:'user_success')]
    public function index(){
        return $this->render('user/success.html.twig');
    }
}
