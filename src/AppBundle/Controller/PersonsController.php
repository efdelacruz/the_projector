<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PersonsController extends Controller
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
}
