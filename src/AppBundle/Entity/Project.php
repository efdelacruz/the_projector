<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Projects")
 */
class Project
{
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=50)
   */
  private $code;

  /**
   * @ORM\Column(type="string", length=50)
   */
  private $name;

  /**
   * @ORM\Column(type="text")
   */
  private $remarks;

  /**
   * @ORM\Column(type="decimal", precision=18, scale=4)
   */
  private $budget;

  /**
   * @ORM\OneToMany(targetEntity="ProjectAssignment", mappedBy="project")
   */
  private $project_assignments;

  public function __construct()
  {
    $this->project_assignments = new ArrayCollection();
  }

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
     * Set code
     *
     * @param string $code
     * @return Project
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return Project
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string 
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set budget
     *
     * @param string $budget
     * @return Project
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return string 
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Add project_assignments
     *
     * @param \AppBundle\Entity\ProjectAssignment $projectAssignments
     * @return Project
     */
    public function addProjectAssignment(\AppBundle\Entity\ProjectAssignment $projectAssignments)
    {
        $this->project_assignments[] = $projectAssignments;

        return $this;
    }

    /**
     * Remove project_assignments
     *
     * @param \AppBundle\Entity\ProjectAssignment $projectAssignments
     */
    public function removeProjectAssignment(\AppBundle\Entity\ProjectAssignment $projectAssignments)
    {
        $this->project_assignments->removeElement($projectAssignments);
    }

    /**
     * Get project_assignments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjectAssignments()
    {
        return $this->project_assignments;
    }
}
