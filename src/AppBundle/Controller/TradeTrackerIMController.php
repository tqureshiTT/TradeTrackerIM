<?php

// src/AppBundle/Controller/TradeTrackerIMController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\People;
use Symfony\Component\HttpFoundation\Response;
use TradeTrackerIM\PeopleBundle\Document\dPeople;

class TradeTrackerIMController extends Controller
{
	/**
	 *   @Route("/setup")
	 **/
	public function TTsetup()
	{
	 	$number = rand(0, 100);
		return new Response(
			'<html><body>Lucky number: '.$number.'</body></html>'
		);
	}

	/**
	 *   @Route("/test")
	 **/
	public function TTtest()
	{
		$names = array(
    			'Christopher',
    			'Ryan',
    			'Ethan',
    			'John',
    			'Zoey',
    			'Sarah',
    			'Michelle',
    			'Samantha',
			);
 
		//PHP array containing surnames.
		$surnames = array(
    			'Walker',
    			'Thompson',
    			'Anderson',
    			'Johnson',
    			'Tremblay',
    			'Peltier',
    			'Cunningham',
    			'Simpson',
    			'Mercado',
    			'Sellers'
			);
 
		//Generate a random forename.
		$random_name = $names[mt_rand(0, sizeof($names) - 1)];
 
		//Generate a random surname.
		$random_surname = $surnames[mt_rand(0, sizeof($surnames) - 1)];
 
		//Combine them together and print out the result.
		//echo $random_name . ' ' . $random_surname;

	 	$age= rand(0, 65);

		$people = new People();
    		$people->setLastName($random_surname);
    		$people->setFirstName($random_name); 
		$people->setAge($age);

    		$em = $this->getDoctrine()->getManager();

    		$em->persist($people);
    		$em->flush();

		return new Response(
			'<html><body>First Name:'.$random_name.' Last Name:'.$random_surname.' Age:'.$age.'</body></html>'
		);
	}

	/**
	 *   @Route("/takedown")
	 **/
	public function TTtakedown()
	{
	 	$number = rand(0, 100);
		return new Response(
			'<html><body>Lucky number: '.$number.'</body></html>'
		);
	}

	/**
	 *   @Route("/transfer")
	 **/
	public function TTtransfer()
	{

		$em = $this->getDoctrine()->getManager();
		$dm = $this->get('doctrine_mongodb')->getManager();

		$repository = $this->getDoctrine()
			->getRepository('AppBundle:People');
		$allpeople = $repository->findAll();
		
		$return_table='<table>';

		$delete = 'n';

		foreach ($allpeople as &$t_people)
		{

			try
			{
				$return_table=$return_table.'<tr>';
				$return_table=$return_table.'<td>'.$t_people->getId().'</td>';
				$return_table=$return_table.'<td>'.$t_people->getFirstName().'</td>';
				$return_table=$return_table.'<td>'.$t_people->getLastName().'</td>';
				$return_table=$return_table.'<td>'.$t_people->getAge().'</td>';
				$return_table=$return_table.'</tr>';
				$em->remove($t_people);
				$em->flush();
				$delete='y';
			}
			catch (Exception $e)
			{

			}
			if (strcmp($delete, 'y') == 0)
			{
				$d_people = new dPeople();
				$d_people->setLastName($t_people->getLastName());
				$d_people->setFirstName($t_people->getFirstName());
				$d_people->setAge($t_people->getAge());
    				$dm->persist($d_people);
    				$dm->flush();
			}
		}

		$return_table=$return_table.'</table>';

		return new Response(
			'<html><body>'.$return_table.'</body></html>'
		);
	}

	/**
	 *   @Route("/count")
	 **/
	public function TTcount()
	{
		$message = "";
		$collection = $this->get('doctrine_mongodb')->getManager()->getDocumentCollection('TradeTrackerIM\PeopleBundle\Document\dPeople')->find()->count();
		
		return new Response(
			'<html><body>'.$collection.'</body></html>'
		);
	}

	/**
	 *   @Route("/teardown")
	 **/
	public function TTteardown()
	{
	 	$number = rand(0, 100);
		return new Response(
			'<html><body>Lucky number: '.$number.'</body></html>'
		);
	}
}
