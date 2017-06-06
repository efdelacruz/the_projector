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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;

class ProjectAssignmentsController extends Controller
{
  /**
   * @Route("/projector/projects/{project_id}/assignments", name="view_assignments")
   */
  public function viewAssignmentsAction(Request $request, $project_id)
  {
    if ($request->isXmlHttpRequest())
    {
      $conn = $this->get('database_connection');

      $assignments_service = new AssignmentsService($conn);
      $ret = $assignments_service->getAssignedPersonsOnProject($project_id);

      return new JsonResponse(json_encode(array(
        'project_assignments' => $ret["assigned_list"],
        'project_unassigned_list' => $ret["unassigned_list"],
        'project_id' => $project_id,
        'project_name' => $ret["project_name"]
      )));

    }else{
      return $this->render('project_assignments/index_angular.html.twig');
    }
  }

  /**
   * @Route("/projector/projects/assign", name="assign_person")
   */
  public function assignPersonToProject(Request $request)
  {
    if ($request->isXmlHttpRequest())
    {
      $project_id = $request->request->get('project_id');
      $person_id = $request->request->get('person_id');
      $conn = $this->get('database_connection');

      $assignments_service = new AssignmentsService($conn);
      $assignments_service->addPersonToProject($project_id, $person_id);

      return new JsonResponse(json_encode(array(
        'success'=>true,
        'status'=>200
      )));
    }
  }

  /**
   * @Route("/projector/projects/unassign", name="unassign_person")
   */
  public function unassignPersonFromProject(Request $request)
  {
    if ($request->isXmlHttpRequest())
    {
      $project_id = $request->request->get('project_id');
      $person_id = $request->request->get('person_id');
      $conn = $this->get('database_connection');

      $assignments_service = new AssignmentsService($conn);
      $assignments_service->removePersonFromProject($project_id, $person_id);

      return new JsonResponse(json_encode(array(
        'success'=>true,
        'status'=>200
      )));
    }
  }
}
