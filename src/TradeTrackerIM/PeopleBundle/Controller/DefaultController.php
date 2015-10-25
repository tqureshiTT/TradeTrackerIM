<?php

namespace TradeTrackerIM\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TradeTrackerIMPeopleBundle:Default:index.html.twig', array('name' => $name));
    }
}
