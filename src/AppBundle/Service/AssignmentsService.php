<?php

namespace AppBundle\Service;

use Doctrine\DBAL\Statement;
use Doctrine\DBAL\Connection;

class AssignmentsService
{
  private $conn;

  public function __construct(Connection $dbalConnection){
    $this->conn = $dbalConnection;
  }

  public function getAssignedPersonsOnProject($project_id)
  {
    $sql = "SELECT Persons.id, Persons.first_name,
      Persons.last_name FROM ProjectAssignments INNER JOIN Persons
      ON ProjectAssignments.person_id = Persons.id WHERE project_id = :project_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue("project_id", $project_id);
    $stmt->execute();
    $assigned_list = $stmt->fetchAll();

    $sql2 = "SELECT Persons.id, Persons.first_name, Persons.last_name
      FROM Persons WHERE Persons.id NOT IN ( SELECT person_id FROM ProjectAssignments
      WHERE project_id = :project_id )";
    $stmt = $this->conn->prepare($sql2);
    $stmt->bindValue("project_id", $project_id);
    $stmt->execute();
    $unassigned_list = $stmt->fetchAll();

    $sql3 = "SELECT Projects.name from Projects WHERE Projects.id = :project_id";
    $stmt = $this->conn->prepare($sql3);
    $stmt->bindValue("project_id", $project_id);
    $stmt->execute();
    $proj_name = $stmt->fetchColumn();

    return array("project_name" => $proj_name, "assigned_list" => $assigned_list, "unassigned_list" => $unassigned_list);
  }

  public function addPersonToProject($project_id, $person_id){
    $sql = "INSERT INTO ProjectAssignments(project_id, person_id)
      VALUES (:project_id, :person_id)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue("project_id", $project_id);
    $stmt->bindValue("person_id", $person_id);
    $stmt->execute();
  }

  public function removePersonFromProject($project_id, $person_id){
    $sql = "DELETE FROM ProjectAssignments WHERE project_id = :project_id
      AND person_id = :person_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue("project_id", $project_id);
    $stmt->bindValue("person_id", $person_id);
    $stmt->execute();
  }

  public function getLastMovedPerson($person_id){
    $sql = "SELECT Persons.first_name, Persons.last_name FROM Persons WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue("id", $person_id);
    $stmt->execute();

    return $stmt->fetch();
  }
}
