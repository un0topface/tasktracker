<?php

namespace AppBundle\Controller;

use AppBundle\Document\Comment;
use AppBundle\Document\Task;
use AppBundle\Document\User;
use AppBundle\Repository\TaskRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * @Route("/task")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/task/{selectedTaskId}", name="selectedTask")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function taskAction($selectedTaskId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TaskRepository $taskRepo */
        $taskRepo    = $dm->getRepository('AppBundle:Task');

        $users = $dm->getRepository('AppBundle:User')->findAll();

        /** @var Task $task */
        $task = $taskRepo->find($selectedTaskId);
        return $this->render('task/index.html.twig', [
            'task'                => $task,
            'users'               => $users,
            'selectedProjectId'   => $task->getProject()->getId(),
        ]);
    }

    /**
     * @Route("/task/{taskId}/edit")
     * @param Request $request
     * @param $taskId
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ODM\MongoDB\LockException
     */
    public function editTaskAction(Request $request, $taskId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TaskRepository $taskRepo */
        $taskRepo    = $dm->getRepository('AppBundle:Task');
        $userRepo    = $dm->getRepository('AppBundle:User');

        /** @var Task $task */
        $task = $taskRepo->find($taskId);

        /**
         * @var User $customer
         * @var User $performer
         */
        $customer  = $userRepo->find($request->get('customer'));
        $performer = $userRepo->find($request->get('performer'));

        $taskBeforeSave = $task->export();

        $task->setMessage($request->get('message'))
            ->setDeadline($request->get('deadLine'))
            ->setProgress((int) $request->get('progress', 0))
            ->setPriorityLevel($request->get('priorityLevel'))
            ->setTimeHoursEstimate($request->get('timeHoursEstimate'))
            ->setStatus($request->get('status'))
            ->setPerformer($performer)
            ->setCustomer($customer);
        $dm->flush();

        $taskAfterSave = $task->export();

        // вычисляем данные для логирования изменений
        $logs = [];
        foreach ($taskBeforeSave as $key => $value) {
            if ($taskAfterSave[$key] != $value) {
                $logs[$key] = [
                    'old'   =>  $value,
                    'new'   =>  $taskAfterSave[$key],
                ];
            }
        }

        if (!empty($logs)) {
            // постим коммент
            $comment = new Comment();
            $comment->setTask($task)
                ->setAuthor($this->getUser())
                ->setLog($logs);
            $dm->persist($comment);
            $dm->flush();
        }

        return $this->redirectToRoute('selectedTask', ['selectedTaskId' => $taskId]);
    }
    /**
     * @Route("/task/{taskId}/comment/post")
     * @param Request $request
     * @param $taskId
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ODM\MongoDB\LockException
     */
    public function createCommentAction(Request $request, $taskId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TaskRepository $taskRepo */
        $taskRepo    = $dm->getRepository('AppBundle:Task');

        /** @var Task $task */
        $task = $taskRepo->find($taskId);

        if (trim($request->get('message'))) {
            // постим коммент
            $comment = new Comment();
            $comment->setTask($task)
                ->setAuthor($this->getUser())
                ->setMessage(trim($request->get('message')));
            $dm->persist($comment);
            $dm->flush();
        }

        return $this->redirectToRoute('selectedTask', ['selectedTaskId' => $taskId]);
    }
}
