<?php
namespace AppBundle\Security;

use AppBundle\Entity\Person;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class PersonProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $em = $this->getDoctrine()->getManager();
        $userData = $em->getRepository('AppBundle:Person')->findByUsername($username);
        // pretend it returns an array on success, false if there is no user

        if ($userData) {
            $password = $userData->getPassword();


            return new Person($username, $password, $roles);
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
