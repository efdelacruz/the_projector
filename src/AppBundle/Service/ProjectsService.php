<?php

namespace AppBundle\Service;

class ProjectsService
{
  public function getProjectName($project_id, $conn)
  {
    $sql = "SELECT name from Projects WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue("id", $project_id);
    $stmt->execute();

    return $stmt->fetchColumn();
  }
}
