<?php

namespace AppBundle\Service;

use Doctrine\DBAL\Statement;

class AssignmentsService
{
  public function getAssignedPersonsOnProject($project_id, $conn)
  {
    $sql = "SELECT Persons.id, Persons.first_name,
      Persons.last_name FROM ProjectAssignments INNER JOIN Persons
      ON ProjectAssignments.person_id = Persons.id WHERE project_id = :project_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue("project_id", $project_id);
    $stmt->execute();
    $assigned_list = $stmt->fetchAll();

    $sql2 = "SELECT Persons.id, Persons.first_name, Persons.last_name
      FROM Persons WHERE Persons.id NOT IN ( SELECT person_id FROM ProjectAssignments
      WHERE project_id = :project_id )";
    $stmt = $conn->prepare($sql2);
    $stmt->bindValue("project_id", $project_id);
    $stmt->execute();
    $unassigned_list = $stmt->fetchAll();

    return array("assigned_list" => $assigned_list, "unassigned_list" => $unassigned_list);
  }

  public function addPersonToProject($project_id, $person_id, $conn){
    $sql = "INSERT INTO ProjectAssignments(project_id, person_id)
      VALUES (:project_id, :person_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue("project_id", $project_id);
    $stmt->bindValue("person_id", $person_id);
    $stmt->execute();
  }

  public function removePersonFromProject($project_id, $person_id, $conn){
    $sql = "DELETE FROM ProjectAssignments WHERE project_id = :project_id
      AND person_id = :person_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue("project_id", $project_id);
    $stmt->bindValue("person_id", $person_id);
    $stmt->execute();
  }

  public function getLastAssignedPerson($person_id, $conn){
    $sql = "SELECT Persons.first_name, Persons.last_name FROM Persons WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue("id", $person_id);
    $stmt->execute();

    return $stmt->fetch();
  }

  public function getLastUnassignedPersonOnProject($project_id, $person_id, $conn){
    //$sql = "SELECT Persons.id, Persons.first_name,
    //  Persons.last_name FROM ProjectAssignments INNER JOIN Persons
    //  ON ProjectAssignments.person_id = Persons.id WHERE project_id = :project_id
    //  AND person_id = :person_id";
    $stmt = $conn->prepare($sql);
    //$stmt->bindValue("project_id", $project_id);
    //$stmt->bindValue("person_id", $person_id);
    $stmt->execute();
  }
}
