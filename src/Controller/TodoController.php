<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session =$request->getSession();
        if(!$session->has('todos')){
            $todos = [
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            ];
            $session->set('todos',$todos);
            $this->addFlash('info',"La liste des todos viens d'etre crée");
        }
        return $this->render('todo/index.html.twig');
    }
    #[Route('/todo/add/{name?demain}/{content?web}',
        name: 'todo.add'
    )]
    public function addTodo(Request $request, $name,$content): Response
    {
        $session=$request->getSession();
        if($session->has('todos')){
            $todos=$session->get('todos');
            if(isset($todos[$name])){
                $this->addFlash('error',"Le Todo d'id $name existe deja dans la liste");
            }else{
                $todos[$name] = $content;
                $this->addFlash('success',"Le todo d'id $name est ajouté avec succès");
                $session->set('todos',$todos);
            }

        }else{
            $this->addFlash('error',"La liste des todos n'est pas encore crée");
        }
        return $this->redirectToRoute('app_todo');

    }
    #[Route("/todo/delete/{name}",name: 'todo.delete')]
    public function delete(Request $request,$name) : Response
    {
        $session=$request->getSession();
        if($session->has('todos')){
            $todos=$session->get('todos');
            if(!isset($todos[$name])){
                $this->addFlash('error',"Le Todo d'id $name n'existe pas dans la liste");
            }else{
                unset($todos[$name]);
                $this->addFlash('success',"Le todo d'id $name est supprimé avec succès");
                $session->set('todos',$todos);
            }

        }else{
            $this->addFlash('error',"La liste des todos n'est pas encore crée");
        }
        return $this->redirectToRoute('app_todo');

    }
    #[Route('/todo/edit/{name}/{content}')]
    public function edit(Request $request, $name,$content): Response
    {
        $session=$request->getSession();
        if($session->has('todos')){
            $todos=$session->get('todos');
            if(!isset($todos[$name])){
                $this->addFlash('error',"Le Todo d'id $name n'existe pas dans la liste");
            }else{
                $todos[$name]=$content;
                $this->addFlash('success',"Le todo d'id $name est mis a jour avec succès");
                $session->set('todos',$todos);
            }
        }else{
            $this->addFlash('error',"La liste des todos n'est pas encore crée");
        }
        return $this->redirectToRoute('app_todo');

    }
    #[Route('/todo/reset', name: 'todo.reset')]
    public function reset(Request $request): Response
    {
        $session=$request->getSession();
        $session->remove('todos');
        $this->addFlash('info','La liste des todos est reinitialisé');
        return $this->redirectToRoute("app_todo");
    }
}
