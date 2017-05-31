<?php

namespace AppBundle\Service;

use \PDO;
use Doctrine\DBAL\Connection;

class ProjectsService
{
  private $conn;

  public function __construct(Connection $dbalConnection){
    $this->conn = $dbalConnection;
  }

  public function getProjectName($project_id)
  {
    $sql = "SELECT name FROM Projects WHERE id = :id";
    $stmt = $this->$this->conn->prepare($sql);
    $stmt->bindValue("id", $project_id);
    $stmt->execute();

    return $stmt->fetchColumn();
  }

  public function getMaxPages()
  {
    $sql = "SELECT COUNT(1) FROM Projects";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $proj_count = $stmt->fetchColumn(0);

    return ceil( (int)$proj_count / 5 );
  }

  public function getProjects($page = 1)
  {
    $sql = "SELECT id,name,budget FROM Projects LIMIT :start_row, 5";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue("start_row", ($page*5)-5, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
  }
}
