<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb<\d+>?5}', name: 'app_tab')]
    public function index($nb): Response
    {
        $notes=[];
        for($i=0;$i<$nb;$i++){
            $notes[]=rand(0,20);
        }
        return $this->render('tab/index.html.twig', [
            'notes'=>$notes ,
        ]);
    }
    #[Route('/tab/users',name: 'tab.users')]
    public function users():Response
    {
        $users =[
            ["firstname"=>"Nour","lastname"=>'Jouini','age'=>20],
            ["firstname"=>"Aziz","lastname"=>'Jouini','age'=>18],
            ["firstname"=>"Nouran","lastname"=>'Jouini','age'=>15]
        ];
        return $this->render('tab/users.html.twig',[
            "users"=>$users
        ]);
    }
}
