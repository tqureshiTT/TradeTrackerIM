<?php

// src/AppBundle/Controller/TradeTrackerIMController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\People;
use Symfony\Component\HttpFoundation\Response;
use TradeTrackerIM\PeopleBundle\Document\dPeople;
use Aws\ElasticLoadBalancing\ElasticLoadBalancingClient;
use Aws\CodeDeploy\CodeDeployClient;


class TradeTrackerIMController extends Controller
{
	/**
	 * @Route("/setup")
	 * @Method("post")
	 **/
	public function TTsetup()
	{
		$resultmessage='';
		try {

			$params = array();
    			$content = $this->get("request")->getContent();
    			if (!empty($content))
    			{
        			$params = json_decode($content, true); 
				echo $params->head_commit->id;
			//	echo $content->search('head_commit[0].id');
    			}
			
			//$output = shell_exec('echo This is $HOME');
			//echo "<pre>$output</pre>";
  			//If the exception is thrown, this text will not be shown
  			echo 'If you see this, the number is 2 or below';

			$client = CodeDeployClient::factory(array(
    				'credentials' => array(
        				'key'    => 'AKIAI3JAB55JBACNU2YA',
        				'secret' => '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',
					),
    				'profile' => '',
    				'region'  => 'us-east-1',
				'version' => '2014-10-06'
			));
  			echo 'If you see this, the number is 1 or below';

			$result = $client->createDeploymentAsync([
    				'applicationName' => 'TradeTracker', // REQUIRED
    				'deploymentConfigName' => 'CodeDeployDefault.AllAtOnce',
    				'deploymentGroupName' => 'TradeTrackerSymfony',
    				'description' => 'Trade Tracker Release',
    				'ignoreApplicationStopFailures' => true,
    				'revision' => [
        				'gitHubLocation' => [
            					'commitId' => 'f8147eb85ab18ab0c1b605135bb65a89f0204f41',
            					'repository' => 'tqureshiTT/TradeTrackerIM',
        				],
        				'revisionType' => 'GitHub',
    				],
			]);
		}
		//catch exception
		catch(Exception $e) {
  			$resultmessage='Message: ' .$e->getMessage();
		}
/*
		$result = $client->createLoadBalancer(array(
    				// LoadBalancerName is required
    				'LoadBalancerName' => 'string',
    				// Listeners is required
    				'Listeners' => array(
        				array(
            					// Protocol is required
            					'Protocol' => 'string',
            					// LoadBalancerPort is required
            					'LoadBalancerPort' => integer,
            					'InstanceProtocol' => 'string',
            					// InstancePort is required
            					'InstancePort' => integer,
            					'SSLCertificateId' => 'string',
        				),
        				// ... repeated
    				),
    				'AvailabilityZones' => array('string', ... ),
    				'Subnets' => array('string', ... ),
    				'SecurityGroups' => array('string', ... ),
    				'Scheme' => 'string',
    				'Tags' => array(
        				array(
            				// Key is required
            				'Key' => 'string',
            				'Value' => 'string',
        				),
        				// ... repeated
    				),
		));

*/
		return new Response(
			'<html><body>'.$resultmessage.'</body></html>'
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
