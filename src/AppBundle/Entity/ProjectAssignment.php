<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ProjectAssignments")
 */
class ProjectAssignment
{
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="Project", inversedBy="project_assignments")
   * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
   */
  private $project;

  /**
   * @ORM\ManyToOne(targetEntity="Person", inversedBy="project_assignments")
   * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
   */
  private $person;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     * @return ProjectAssignment
     */
    public function setProject(\AppBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set person
     *
     * @param \AppBundle\Entity\Person $person
     * @return ProjectAssignment
     */
    public function setPerson(\AppBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \AppBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }
}
