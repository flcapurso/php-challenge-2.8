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
        $todosArray = [];
        foreach ($todos as $todo) {
            $todosArray[] = ['id' => $todo->getId(), 'body' => $todo->getBody(), 'completed' => $todo->getCompleted()];
        }

        return new JsonResponse($todosArray);
    }

    /**
     * @Route("/main/remove", name="remove_todo", options={"expose"=true})
     */
    public function removeAction(Request $request)
    {   
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $todoId = $request->request->get('id');
        $todo = $em->getRepository('AppBundle:Todo')->find($todoId);

        if (!$todo) {
            throw $this->createNotFoundException(
                'No product found for id '.$todoId
            );
        }

        $user->removeTodo($todo);
        $em->remove($todo);
        $em->flush();


        return new JsonResponse("Item removed Correctly");
    }

    /**
     * @Route("/main/complete", name="complete_todo", options={"expose"=true})
     */
    public function completeAction(Request $request)
    {   
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $todoId = $request->request->get('id');
        $todo = $em->getRepository('AppBundle:Todo')->find($todoId);

        if (!$todo) {
            throw $this->createNotFoundException(
                'No product found for id '.$todoId
            );
        }

        $todo->setCompleted(! $todo->getCompleted());
        $em->flush();


        return new JsonResponse("Completed state updated with".$todo->getCompleted());
    }


    /**
     * @Route("/main/completeAll", name="complete_all", options={"expose"=true})
     */
    public function completeAllAction()
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $todos = $user->getTodos();
        $todos = $todos->toArray();

        $actionDone = '';
        $falseItemsNumber = 0;
        foreach ($todos as $todo) {
            if (! $todo->getCompleted()){
                $falseItemsNumber++;
            }
        }

        if ($falseItemsNumber == 0){

            foreach ($todos as $todo) {
                $todo->setCompleted(false);
            }
            $actionDone = 'makeAllFalse';

        } else {

            foreach ($todos as $todo) {
                $todo->setCompleted(true);
            }
            $actionDone = 'makeAllTrue';

        }

        $em->flush();

        return new JsonResponse(['action'=>$actionDone]);
    }

    /**
     * @Route("/main/clearCompleted", name="clear_completed", options={"expose"=true})
     */
    public function clearCompletedAction()
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $todos = $user->getTodos();
        $todos = $todos->toArray();

        $IdArray = [];
        foreach ($todos as $todo) {
            if ($todo->getCompleted()){
                $IdArray[] = ['id' => $todo->getId()];

                $user->removeTodo($todo);
                $em->remove($todo);
            }
        }

        $em->flush();

        return new JsonResponse($IdArray);
    }


    /**
     * @Route("/main/updateBody", name="update_body", options={"expose"=true})
     */
    public function updateBodyAction(Request $request)
    {   
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $todoId = $request->request->get('id');
        $todo = $em->getRepository('AppBundle:Todo')->find($todoId);

        if (!$todo) {
            throw $this->createNotFoundException(
                'No product found for id '.$todoId
            );
        }

        $todo->setBody($request->request->get('newBody'));
        $em->flush();


        return new JsonResponse("Updated body correctly with text: ".$todo->getBody());
    }
} 