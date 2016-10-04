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
     * @Route("/main", name="main"))
     */
    public function mainAction()
    {   
        if (!($this->container->get('security.authorization_checker')->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('homepage');
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $todos = $user->getTodos();

        return $this->render('main.html.twig', array(
            'todos' => $todos
        ));
    }


    /**
     * @Route("/main/create", name="create_todo"))
     */
    public function createAction(Request $request)
    {   $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $data = $request->request->get('request');
        $todo = new Todo();
        $todo->setBody($_POST['body']);
        $todo->setCompleted(false);
        $todo->setUser($user);

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Todo (no queries yet)
        $em->persist($todo);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        
        return new JsonResponse(array($todo->getId(),$todo->getBody()));
    }


    /**
     * @Route("/main/show", name="show_todos"))
     */
    public function showProductsAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $todos = $user->getTodos();

        $todosArray = array();
        $todos = $todos->toArray();
        foreach ($todos as $todo) {
            array_push($todosArray, array($todo->getId(), $todo->getBody(), $todo->getCompleted()) );
        }

        return new JsonResponse($todosArray);
    }
} 