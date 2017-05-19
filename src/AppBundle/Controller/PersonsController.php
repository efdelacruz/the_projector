<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PersonsController extends Controller
{
  /**
   *  @Route("/projector/persons/create", name="new_person")
   */
  public function newPersonAction(Request $request)
  {
    $person = new Person();
    $person->setLastName('My Last Name');
    $person->setFirstName('My First Name');
    $person->setUsername('user@name.com');

    $form = $this->createForm(PersonType::class, $person);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $person = $form->getData();

      $encoder = $this->get('security.password_encoder');
      $password = $encoder->encodePassword($person, $person->getPassword());
      $person->setPassword($password);

      $person->setRole('ROLE_USER');

      $em = $this->getDoctrine()->getManager();
      $em->persist($person);
      $em->flush();

      $this->addFlash(
        'notice',
        'Succesfully created account!'
      );
      return $this->redirectToRoute('projects');
    }

    return $this->render('persons/new.html.twig', array(
      'form' => $form->createView()
    ));
  }
}
