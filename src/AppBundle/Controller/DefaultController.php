<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Path;
use AppBundle\Entity\Project;
use AppBundle\Form\PathType;
use AppBundle\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/addpath", name="add_path")
     */
    public function addPathAction(Request $request)
    {
        $path = new Path();
        $form = $this->createForm(PathType::class, $path);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($path);
            $em->flush();
            return new Response('Ajouté ');
        }
        return $this->render(':default:form.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/addproject", name="add_project")
     */
    public function addProjectAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            return new Response('Ajouté ');
        }
        return $this->render(':default:form.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
