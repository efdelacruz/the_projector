<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Persons")
 * @UniqueEntity(fields="username", message="This username is already in use")
 */
class Person implements UserInterface, EquatableInterface
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
   * @ORM\Column(type="string", length=50, unique=true)
   * @Assert\Length(
   *    min = 5,
   *    max = 200,
   *    minMessage = "Your username must be at least {{ limit }} characters long",
   *    maxMessage = "Your username cannot be longer than {{ limit }} characters"
   * )
   */
  private $username;

  /**
   * @ORM\Column(type="string", length=50)
   * @Assert\Length(
   *    min = 7,
   *    max = 11,
   *    minMessage = "Your password must be at least {{ limit }} characters long",
   *    maxMessage = "Your password cannot be longer than {{ limit }} characters"
   * )
   * @Assert\Regex(
   *    pattern="/^\S{6,}$/",
   *    match=true,
   *    message="Password cannot contain spaces"
   * )
   */
  private $password;

  /**
   * @ORM\Column(type="string", length=50)
  */
  protected $role;

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
     * Set role
     *
     * @param string $role
     * @return Person
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
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

    public function eraseCredentials()
    {
        return null;
    }

    public function getRoles()
    {
        return [$this->getRole()];
    }

    public function getSalt()
    {
        return null;
    }

    public function isEqualTo(UserInterface $user)
    {
      if (!$user instanceof Person) {
          return false;
      }

      if ($this->password !== $user->getPassword()) {
          return false;
      }

      if ($this->username !== $user->getUsername()) {
          return false;
      }

      return true;
    }
}
