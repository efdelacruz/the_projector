<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProjectsController extends Controller
{
  /**
   *  @Route("/projector/projects", name="projects")
   */
  public function viewProjectsAction()
  {
    $em = $this->getDoctrine()->getManager();
    $projects = $em->getRepository('AppBundle:Project')->findAll();

    return $this->render('projects/index.html.twig', array(
      'projects' => $projects
    ));
  }

  /**
   *  @Route("/projector/projects/create", name="new_project")
   */
  public function newProjectAction(Request $request)
  {
    $project = new Project();
    $project->setCode('PROJ_CODE');
    $project->setName('Project Name');
    $project->setBudget(100000);
    $project->setRemarks('Any remarks?');

    $form = $this->createForm(ProjectType::class, $project);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $project = $form->getData();

      $em = $this->getDoctrine()->getManager();
      $em->persist($project);
      $em->flush();

      $this->addFlash(
        'notice',
        'Succesfully created project!'
      );
      return $this->redirectToRoute('projects');
    }

    return $this->render('projects/new.html.twig', array(
      'form' => $form->createView()
    ));
  }

}
