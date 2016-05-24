<?php

namespace AppBundle\Controller;

use AppBundle\Document\Project;
use AppBundle\Document\Task;
use AppBundle\Document\User;
use AppBundle\Repository\ProjectRepository;
use AppBundle\Repository\TaskRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    /**
     * @Route("/project")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/project/{selectedProjectId}")
     * @param string $selectedProjectId id проекта
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectAction($selectedProjectId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TaskRepository $taskRepo */
        $taskRepo    = $dm->getRepository('AppBundle:Task');
        /** @var ProjectRepository $projectRepo */
        $projectRepo = $dm->getRepository('AppBundle:Project');

        /** @var Project $project */
        $project = $projectRepo->find($selectedProjectId);
        $tasks   = $taskRepo->findAllByProject($project);

        return $this->render('project/index.html.twig', [
            'tasks'               => $tasks,
            'selectedProjectId'   => $selectedProjectId,
        ]);
    }

    /**
     * @Route("/tasks/my")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myTasksAction()
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TaskRepository $taskRepo */
        $taskRepo    = $dm->getRepository('AppBundle:Task');

        $tasks   = $taskRepo->findAllByUser($this->getUser());

        return $this->render('project/index.html.twig', [
            'tasks'               => $tasks,
        ]);
    }

    /**
     * @Route("/project/{selectedProjectId}/createTask", name="createTaskAction")
     * @param string $selectedProjectId id проекта
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createTaskAction($selectedProjectId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var ProjectRepository $projectRepo */
        $projectRepo = $dm->getRepository('AppBundle:Project');

        $users = $dm->getRepository('AppBundle:User')->findAll();

        return $this->render('project/createTask.html.twig', [
            'task'                => new Task(),
            'users'               => $users,
            'selectedProjectId'   => $selectedProjectId,
            'project'             => $projectRepo->find($selectedProjectId),
        ]);
    }

    /**
     * @Route("/project/{selectedProjectId}/createTask/save")
     * @param Request $request
     * @param string $selectedProjectId id проекта
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ODM\MongoDB\LockException
     */
    public function createAndSaveTask(Request $request, $selectedProjectId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $userRepo    = $dm->getRepository('AppBundle:User');
        /** @var ProjectRepository $projectRepo */
        $projectRepo = $dm->getRepository('AppBundle:Project');

        /**
         * @var User $customer
         * @var User $performer
         */
        $customer  = $userRepo->find($request->get('customer'));
        $performer = $userRepo->find($request->get('performer'));

        if ($request->get('title')) {
            $task = new Task();
            /** @noinspection PhpParamsInspection */
            $task->setTitle($request->get('title'))
                ->setMessage($request->get('message'))
                ->setDeadline($request->get('deadLine'))
                ->setProgress((int)$request->get('progress', 0))
                ->setPriorityLevel($request->get('priorityLevel'))
                ->setTimeHoursEstimate($request->get('timeHoursEstimate'))
                ->setStatus($request->get('status'))
                ->setPerformer($performer)
                ->setCustomer($customer)
                ->setProject($projectRepo->find($selectedProjectId));
            $dm->persist($task);
            $dm->flush();
        } else {
            return $this->redirectToRoute('createTaskAction', ['selectedProjectId' => $selectedProjectId]);
        }

        return $this->redirectToRoute('selectedTask', ['selectedTaskId' => $task->getId()]);
    }

//    public function createProjectAction()
//    {
//        $project = new Project();
//        $project->setAuthor($this->getUser())
//            ->setName('Сетевые проблемы');
//
//        /** @var DocumentManager $dm */
//        $dm = $this->get('doctrine_mongodb')->getManager();
//        $dm->persist($project);
//        $dm->flush();
//    }
}
