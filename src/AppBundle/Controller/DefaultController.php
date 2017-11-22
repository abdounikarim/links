<?php

namespace AppBundle\Controller;

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
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Path');
        $paths = $repository->findAll();
        return $this->render('default/index.html.twig', [
            'paths' => $paths
        ]);
    }

    /**
     * @Route("/path/{path_id}", name="path")
     */
    public function pathAction($path_id){
        $em = $this->getDoctrine()->getManager();
        $repositoryPath = $em->getRepository('AppBundle:Path');
        $path = $repositoryPath->find($path_id);
        $repositoryProject = $em->getRepository('AppBundle:Project');
        $projects = $repositoryProject->findAllProjectsFromPath($path_id);

        return $this->render(':default:path.html.twig', [
            'path' => $path,
            'projects' => $projects
        ]);
    }

    /**
     * @Route("/project/{project_id}", name="project")
     */
    public function projectAction($project_id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryProject = $em->getRepository('AppBundle:Project');
        $project = $repositoryProject->find($project_id);
        $repositoryLink = $em->getRepository('AppBundle:Link');
        $links = $repositoryLink->findAllLinksFromProject($project_id);
        return $this->render('default/project.html.twig', [
            'project' => $project,
            'links' => $links,
        ]);
    }
}
