<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Link;
use AppBundle\Entity\Path;
use AppBundle\Entity\Project;
use AppBundle\Form\Type\LinkType;
use AppBundle\Form\Type\PathType;
use AppBundle\Form\Type\ProjectType;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin")
     * @Security("is_granted('ROLE_USER')")
     */
    public function adminAction()
    {
        return $this->render('admin/admin.html.twig');
    }

    /**
     * @Route("/add/path", name="add_path")
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
        return $this->render(':form:path.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/edit/path/{path}", name="edit_path")
     */
    public function editPathAction(Request $request, Path $path)
    {
        $form = $this->createForm(PathType::class, $path);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
        }
        return $this->render(':form:path.html.twig', [
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add/project", name="add_project")
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
        return $this->render('form/project.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/edit/project/{project}", name="edit_project")
     */
    public function editProjectAction(Request $request, Project $project)
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
        }
        return $this->render(':form:project.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add/link", name="add_link")
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
        return $this->render('form/link.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/edit/link/{link}", name="edit_link")
     */
    public function editLinkAction(Request $request, Link $link)
    {
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
        }
        return $this->render('form/link.html.twig', [
           'form' => $form->createView()
        ]);
    }
}