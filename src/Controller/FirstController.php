<?php

namespace App\Controller;


use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FirstController extends AbstractController
{
    #[Route("/order/{maVar}", name: 'order.test', )]
    public function testOrderRoute($maVar) :Response
    {
        return new Response('<html lang="en">
            <head>
            <title>Order Tes t</title>
</head>
            <body>
            <h1>le lien consulter a une variable  '.$maVar.'</h1>
</body>
        </html>');
    }
    #[Route('/first', name: 'app_first')]
    public function index(Request $request): Response
    {

        return $this->render('first/index.html.twig',[
            'name' => 'Jouini',
            'firstName' => 'Nour',
            'method' => $request->getMethod(),
            'language'=>$request->getLocale()
        ]);
    }
    #[Route('/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello($name,$firstname): Response
    {

        return $this->render('first/hello.html.twig', [
            'nom'=>$name,
            'prenom'=>$firstname
        ]);
    }
    #[Route('/cv', name:'cv')]
    public function generatorCV(Request $request): Response
    {

        if(!($request->request->get('nom'))){
            $nom = 'Jouini';
        }else{
            $nom=$request->request->get('nom');
        }

        return $this->render('first/cv.html.twig',[

                'nom'=>$nom ,
                'prenom'=>'Nour',
                'age'=>20,
                'section'=>'GL'
            ]
        );
    }
    #[Route('/test',name:'test')]
    public function test(Request $request): Response
    {
        $request->request->add(['nom'=>'Nouri']);
        return $this->forward('App\Controller\FirstController::generatorCV');
    }
    #[Route( '/multi/{entier1<\d+>}/{entier2<\d+>}',
        name: 'multiplication'
    )]
    public function multiplication($entier1, $entier2):Response
    {
        $resultat=$entier1 *$entier2;
        return new Response("<h1>Le resultat de votre requete est : $resultat</h1>");
    }
}
