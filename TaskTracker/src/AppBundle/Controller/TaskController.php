<?php

namespace AppBundle\Controller;

use AppBundle\Document\Comment;
use AppBundle\Document\Task;
use AppBundle\Repository\TaskRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * @Route("/task")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/task/{selectedTaskId}")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectAction($selectedTaskId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TaskRepository $taskRepo */
        $taskRepo    = $dm->getRepository('AppBundle:Task');

        /** @var Task $task */
        $task = $taskRepo->find($selectedTaskId);
//        $this->createCommentAction();
        return $this->render('task/index.html.twig', [
            'task'                => $task,
            'selectedProjectId'   => $task->getProject()->getId(),
        ]);
    }

    public function createCommentAction()
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TaskRepository $taskRepo */
        $taskRepo    = $dm->getRepository('AppBundle:Task');
        /** @var Task $task */
        $task = $taskRepo->find('573e4bd084aa3a1e008b456a');

        $comment = new Comment();
        $comment->setMessage('Говно какое-то')
            ->setTask($task)
            ->setAuthor($this->getUser())
            ->setLog([
                'progress'  =>  [
                    'old'   =>  10,
                    'new'   =>  55,
                ],
                'timeHoursEstimate' =>  [
                    'old'   =>  0,
                    'new'   =>  5,
                ]
            ]);
        $dm->persist($comment);
        $dm->flush();
    }
}
