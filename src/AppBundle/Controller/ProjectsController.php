<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;
use AppBundle\Service\ProjectsService;

class ProjectsController extends Controller
{
  /**
   *  @Route("/projector/projects", name="projects")
   */
  public function viewProjectsAction(Request $request, $page = 1)
  {
    if ($request->query->get('page') != null){
      $page = $request->query->get('page');
    }
    $conn = $this->get('database_connection');
    $proj_service = new ProjectsService();
    $projects = $proj_service->getProjects($conn, $page);

    $max_page = $proj_service->getMaxPages($conn);

    return $this->render('projects/index.html.twig', array(
      'projects' => $projects,
      'page' => $page,
      'max_page' => $max_page
    ));
  }

  /**
   *  @Route("/projector/projects/create", name="new_project")
   */
  public function newProjectAction(Request $request)
  {
    $project = new Project();

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
