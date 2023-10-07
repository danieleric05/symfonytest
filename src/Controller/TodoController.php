<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        //Afficher notre tableau de TOdo
        //sinon je l'initialise
        if (!$session->has('todos')) {
            $todos = array(
                'achat' => 'acheter une clé usb',
                'course' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            );
            $session->set('todos', $todos);
            $this->addFlash('info', "la liste des Todos vient d''être réinitialiser");

        }
        //si j'ai mon tableau de todo dans ma session je ne fait que l'afficher

        return $this->render('todo/index.html.twig');
    }

    #[Route(
        '/add/{name?test}/{content?test}',
        name: 'todo.add')]
    public function addTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        //Vérifier si j'ai mon tableau de Todo dans la session
        if ($session->has('todos')) {
            //si oui
            //Vérifer si on a déjà un
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                $this->addFlash('error', "Le todo d'id $name existe déjà dans la liste");
            } else {
                // si non on affiche un message de succès
                $todos[$name] = $content;
                $this->addFlash('success', "Le todo d'id $name a été ajouté avec succès");
                $session->set('todos', $todos);
            }
        } else {
            //si non
            //afficher une erreur et on va rediriger vers le controlleur
            $this->addFlash('error', "la liste des Todos n'est pas encore initialisé");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        //Vérifier si j'ai mon tableau de Todo dans la session
        if ($session->has('todos')) {
            //si oui
            //Vérifer si on a déjà un
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('error', "Le todo d'id $name n'existe déjà dans la liste");
            } else {
                // si non on affiche un message de succès
                $todos[$name] = $content;
                $this->addFlash('success', "Le todo d'id $name a été modifié avec succès");
                $session->set('todos', $todos);
            }
        } else {
            //si non
            //afficher une erreur et on va rediriger vers le controlleur
            $this->addFlash('error', "la liste des Todos n'est pas encore initialisé");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse
    {
        $session = $request->getSession();
        //Vérifier si j'ai mon tableau de Todo dans la session
        if ($session->has('todos')) {
            //si oui
            //Vérifer si on a déjà un
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('error', "Le todo d'id $name n'existe déjà dans la liste");
            } else {
                // si non on affiche un message de succès
                unset($todos[$name]);
                $this->addFlash('success', "Le todo d'id $name a été supprimé avec succès");
                $session->set('todos', $todos);
            }
        } else {
            //si non
            //afficher une erreur et on va rediriger vers le controlleur
            $this->addFlash('error', "la liste des Todos n'est pas encore initialisé");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('todo');
    }
}