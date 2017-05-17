<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Persons")
 */
class Person
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
  private $last_name;

  /**
   * @ORM\Column(type="string", length=50)
   */
  private $first_name;

  /**
   * @ORM\Column(type="string", length=50)
   */
  private $username;

  /**
   * @ORM\Column(type="string", length=50)
   */
  private $password;

  /**
   * @ORM\OneToMany(targetEntity="ProjectAssignment", mappedBy="person")
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
     * Set last_name
     *
     * @param string $lastName
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Person
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Person
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add project_assignments
     *
     * @param \AppBundle\Entity\ProjectAssignment $projectAssignments
     * @return Person
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
