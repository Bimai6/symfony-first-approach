<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;

final class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[Route('/user/create_user', name: 'create_user')]
    public function createUser(): Response{
        $user = new User();
        $user->setName('Javi');
        $user->setSurname('Ariza Rosales');
        $user->setAge(21);
        $user->setDni('12345678A');

        $this->em->persist($user);

        $this->em->flush();

        return new Response('Saved new user with id ' . $user->getId());
    }

    #[Route('user/form', name:'app_form'), ]
    public function processForm(Request $request): Response {
        
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $this->em->persist($user);

            $this->em->flush();

            return $this->redirectToRoute('user_success');
        }

        return $this->render('user/form.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('user/confirmed', name:'user_success')]
    public function index(){
        return $this->render('user/success.html.twig');
    }

    #[Route('user/{id}', name:'user_show')]
    public function show(int $id): Response {
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        return new Response('Check out this great user: '.$user->getName());
    }

    #[Route('user/edit/{id}', name:'user_update')]
    public function update(Request $request, int $id) : Response{
        $user= $this->em->getRepository(User::class)->find($id);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $this->em->flush();

            return new Response('User with id ' . $id . ' has been update!');
        }

        return $this->render('user/update.html.twig', [
            'form' => $form,
            'username' => $user->getName()
        ]);
    }
}
