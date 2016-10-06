<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Todo;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/main", name="main")
     */
    public function mainAction()
    {   
        if (! $this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('homepage');
        }
        $user = $this->getUser();

        $todos = $user->getTodos();

        return $this->render('main.html.twig', ['todos' => $todos]);
    }


    /**
     * @Route("/main/create", name="create_todo", options={"expose"=true})
     */
    public function createAction(Request $request)
    {   
        $user = $this->getUser();

        $data = $request->request->get('request');
        $todo = new Todo();
        $todo->setBody($request->request->get('body'));
        $todo->setCompleted(false);
        $todo->setUser($user);

        $em = $this->getDoctrine()->getManager();

        $em->persist($todo);

        $em->flush();
        
        return new JsonResponse([ 'id' => $todo->getId(), 'body' => $todo->getBody(), ]);
    }


    /**
     * @Route("/main/show", name="show_todos", options={"expose"=true})
     */
    public function showProductsAction()
    {
        $user = $this->getUser();

        $todos = $user->getTodos();

        
        $todos = $todos->toArray();
        foreach ($todos as $todo) {
            $todosArray[] = ['id' => $todo->getId(), 'body' => $todo->getBody(), 'completed' => $todo->getCompleted()];
        }

        return new JsonResponse($todosArray);
    }
} 