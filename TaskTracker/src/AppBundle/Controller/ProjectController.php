<?php

namespace AppBundle\Controller;

use AppBundle\Document\Project;
use AppBundle\Document\Task;
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

//    public function createTaskAction()
//    {
//        /** @var DocumentManager $dm */
//        $dm = $this->get('doctrine_mongodb')->getManager();
//        /** @var ProjectRepository $projectRepo */
//        $projectRepo = $dm->getRepository('AppBundle:Project');
//
//        $task = new Task();
//        $task->setProject($projectRepo->find('573e362c84aa3a3f008b4567'))
//            ->setTitle('Купить монитор Владимиру Путину')
//            ->setMessage('Dell U2715H')
//            ->setProgress(100)
//            ->setCustomer($this->getUser());
//
//        $dm->persist($task);
//        $dm->flush();
//    }
//
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
