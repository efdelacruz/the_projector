<?php
namespace AppBundle\Security;

use AppBundle\Entity\Person;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;

class PersonProvider implements UserProviderInterface
{
  public function __construct (\Doctrine\Bundle\DoctrineBundle\Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

  public function loadUserByUsername($username)
  {
    $em = $this->doctrine->getManager();
    $userData = $em->getRepository('AppBundle:Person')->findOneByUsername($username)

    if ($userData) {
      $username = $userData->getUsername();
      $password = $userData->getPassword();
      $role = $userData->getRole();

      return new Person($username, $password, $role);
    }

    throw new UsernameNotFoundException(
      sprintf('Username "%s" does not exist.', $username)
    );
  }

  public function refreshUser(UserInterface $user)
  {
    if (!$user instanceof Person) {
      throw new UnsupportedUserException(
        sprintf('Instances of "%s" are not supported.', get_class($user))
      );
    }

    return $this->loadUserByUsername($user->getUsername());
  }

  public function supportsClass($class)
  {
    return Person::class === $class;
  }
}
