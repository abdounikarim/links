<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use AppBundle\Entity\Path;
use AppBundle\Entity\Project;
use AppBundle\Form\Type\LinkType;
use AppBundle\Form\Type\PathType;
use AppBundle\Form\Type\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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

    /**
     * @Route("/admin", name="admin")
     * @Security("is_granted('ROLE_USER')")
     */
    public function adminAction()
    {
        return $this->render('admin/admin.html.twig');
    }

    /**
     * @Route("/admin/add/path", name="add_path")
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
            $this->addFlash('add_path', 'Le parcours a bien été ajouté');
            return $this->redirectToRoute('homepage');
        }
        return $this->render(':form:add_path.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/admin/add/project", name="add_project")
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
            $this->addFlash('add_project', 'Le projet a bien été ajouté');
            return $this->redirectToRoute('homepage');
        }
        return $this->render(':form:add_project.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/admin/add/link", name="add_link")
     */
    public function addLinkAction(Request $request)
    {
        $link = new Link();
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();
            $this->addFlash('add_link', 'Le lien a bien été ajouté');
            return $this->redirectToRoute('homepage');
        }
        return $this->render(':form:add_link.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
