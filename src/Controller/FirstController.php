<?php

namespace App\Controller;

use http\Message\Body;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FirstController extends AbstractController
{
    #[Route('/order/{maVar}', name: 'test.order.route')]
    public function testOrderRoute($maVar){
        return new Response("
            <html>
                <body>
                    $maVar
                </body>
            </html>"
        );
    }

    #[Route('/first', name: 'first')]
    public function index(): Response
    {

        return $this->render(
            'first/index.html.twig',
            [
                'name' => 'Aboussou',
                'firstname' => 'Daniel'
            ]
        );
    }

    #[Route('/danielHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(HttpFoundationRequest $request, $name, $firstname): Response
    {
          return $this->render('first/hello.html.twig',
            [
                'nom' => $name,
                'prenom' => $firstname,
                'path' => '           '
            ]);
    }

    #[Route(
        'multi/{entier1}/{entier2}',
        name: 'multiplication',
        requirements: ['entier1'=>'\d+','entier2'=>'\d+']
    )]
    public function multiplication($entier1, $entier2){
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }
}
