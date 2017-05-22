<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Entity\Person;
use AppBundle\Form\ProjectType;
use AppBundle\Service\AssignmentsService;
use AppBundle\Service\ProjectsService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;

class ProjectAssignmentsController extends Controller
{
  /**
   * @Route("/projector/projects/{project_id}/assignments", name="view_assignments")
   */
  public function viewAssignmentsAction(Request $request, $project_id)
  {
    $project_name = $request->query->get('project_name');
    $conn = $this->get('database_connection');

    $assignments_service = new AssignmentsService();
    $ret = $assignments_service->getAssignedPersonsOnProject($project_id, $conn);

    return $this->render('project_assignments/index.html.twig', array(
      'project_assignments' => $ret["assigned_list"],
      'project_unassigned_list' => $ret["unassigned_list"],
      'project_id' => $project_id,
      'project_name' => $project_name
    ));
  }

  /**
   * @Route("/projector/projects/{project_id}/assign", name="assign_person")
   */
  public function assignPersonToProject(Request $request, $project_id)
  {
    $request->isXmlHttpRequest();
    $person_id = $request->request->get('person_id');
    $project_name = $request->query->get('project_name');
    $conn = $this->get('database_connection');

    $assignments_service = new AssignmentsService();

    $assignments_service->addPersonToProject($project_id, $person_id, $conn);
    $ret = $assignments_service->getAssignedPersonsOnProject($project_id, $conn);

    return $this->render('project_assignments/index.html.twig', array(
      'project_assignments' => $ret["assigned_list"],
      'project_unassigned_list' => $ret["unassigned_list"],
      'project_id' => $project_id,
      'project_name' => $project_name
    ));
  }

  /**
   * @Route("/projector/projects/{project_id}/unassign", name="unassign_person")
   */
  public function unassignPersonFromProject(Request $request, $project_id)
  {
    $request->isXmlHttpRequest();
    $person_id = $request->query->get('person_id');
    $project_name = $request->query->get('project_name');
    $conn = $this->get('database_connection');

    $assignments_service = new AssignmentsService();

    $assignments_service->removePersonFromProject($project_id, $person_id, $conn);
    $ret = $assignments_service->getAssignedPersonsOnProject($project_id, $conn);

    return $this->render('project_assignments/index.html.twig', array(
      'project_assignments' => $ret["assigned_list"],
      'project_unassigned_list' => $ret["unassigned_list"],
      'project_id' => $project_id,
      'project_name' => $project_name
    ));
  }
}
