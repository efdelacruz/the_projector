<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
  /**
   *  @Route("/home", name="index")
   */
  public function index()
  {
    $test_str = "Trial check";

    //return new Response(
    //  '<html><body> Message: '.$test_str.'</body></html>'
    //);
    return $this->render('home/index.html.twig', array(
      'test_str' => $test_str,
    ));
  }

  /*
   *  @Route("/projector", name="signin")
   */
  public function signin()
  {
    return $this->render('auth/login.html.twig');
  }
}
