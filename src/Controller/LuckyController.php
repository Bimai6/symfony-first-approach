<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        dump($number);
        $array = [1, 2, 5];
        dump($array);


        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }
}