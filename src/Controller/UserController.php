<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Regex;

final class UserController extends AbstractController
{
    #[Route('/user/create_user', name: 'create_user')]
    public function createUser(EntityManagerInterface $entityManager): Response{
        $user = new User();
        $user->setName('Javi');
        $user->setSurname('Ariza Rosales');
        $user->setAge(21);
        $user->setDni('12345678A');
        $user->setCreatedAt(new DateTimeImmutable("now"));

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response('Saved new user with id ' . $user->getId());
    }
}
