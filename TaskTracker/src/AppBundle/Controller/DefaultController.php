<?php

namespace AppBundle\Controller;

use AppBundle\Document\Project;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();

        $projects = $dm->getRepository('AppBundle:Project')->findAll();

        return $this->render('default/index.html.twig', [
            'projects'          => $projects,
            'selectedProjectId' => '',
        ]);
    }

    /**
     * @param string $selectedProjectId проекта
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showMenuAction($selectedProjectId = '')
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();

        $projects = $dm->getRepository('AppBundle:Project')->findAll();

        return $this->render('default/menu.html.twig', [
            'selectedProjectId'   => $selectedProjectId,
            'projects'            => $projects,
        ]);
    }
}
