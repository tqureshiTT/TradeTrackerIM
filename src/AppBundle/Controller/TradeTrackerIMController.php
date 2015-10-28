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
use Aws\Ec2\Ec2Client;


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
			// testing push event - 6

			$params = array();
			$commitId = '';
    			$content = $this->get("request")->getContent();
    			if (!empty($content))
    			{
				$params = json_decode($content, false);
                                $commitId = $params->head_commit->id;
				echo $commitId;
    			}
			
			//$output = shell_exec('echo This is $HOME');
			//echo "<pre>$output</pre>";
  			//If the exception is thrown, this text will not be shown
  			//echo 'If you see this, the number is 2 or below';

			$client = CodeDeployClient::factory(array(
    				'credentials' => array(
        				'key'    => 'AKIAI3JAB55JBACNU2YA',
        				'secret' => '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',
					),
    				'profile' => '',
    				'region'  => 'us-east-1',
				'version' => '2014-10-06'
			));
  			//echo 'If you see this, the number is 1 or below';

			$result = $client->createDeployment([
    				'applicationName' => 'TradeTracker', // REQUIRED
    				'deploymentConfigName' => 'CodeDeployDefault.AllAtOnce',
    				'deploymentGroupName' => 'TradeTrackerSymfony',
    				'description' => 'Trade Tracker Release',
    				'ignoreApplicationStopFailures' => true,
    				'revision' => [
        				'gitHubLocation' => [
            					'commitId' => $commitId,
            					'repository' => 'tqureshiTT/TradeTrackerIM',
        				],
        				'revisionType' => 'GitHub',
    				],
			]);
  			$resultmessage='Message: '.$result;
		}
		//catch exception
		catch(Exception $e) {
  			$resultmessage='Message: ' .$e->getMessage();
		}
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

	 	$age= rand(1, 85);

		$people = new People();
    		$people->setLastName($random_surname);
    		$people->setFirstName($random_name); 
		$people->setAge($age);

    		$em = $this->getDoctrine()->getManager();

    		$em->persist($people);
    		$em->flush();

		return new Response('<html><body>First Name:'.$random_name.' Last Name:'.$random_surname.' Age:'.$age.'</body></html>');
	}

	/**
	 *   @Route("/takedown")
	 **/
	public function TTtakedown()
	{
		$client = Ec2Client::factory(array( 'credentials' => array( 'key'    => 'AKIAI3JAB55JBACNU2YA', 'secret' => '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',),
                                'profile' => '', 'region'  => 'us-east-1', 'version' => '2015-10-01'));

			$args = array( 'Filters' => array( array('Name' => 'tag:Name', 'Values' => array('POSTGRESQL') )));
			$results = $client->describeInstances($args);
			$reservations = $results['Reservations'];
			foreach ($reservations as $reservation) {
				echo "1->";
    				$instances = $reservation['Instances'];
    				foreach ($instances as $instance) {
					echo "2->";
        				$instanceName = '';
        				foreach ($instance['Tags'] as $tag) {
            					if ($tag['Key'] == 'Name') {
                					$instanceName = $tag['Value'];
							echo $instanceName;
            					}
        				}
					$instance['InstanceId'];
        				$shutdownInstances['InstanceIds'][] = $instance['InstanceId'];
    				}

			}
			$results = $client->stopInstances($shutdownInstances);
			'<html><body></body></html>'
		);
	}

	/**
	 *   @Route("/transfer")
	 **/
	public function TTtransfer()
	{

		$em = $this->getDoctrine()->getManager();
		$dm = $this->get('doctrine_mongodb')->getManager();

		$repository = $this->getDoctrine()->getRepository('AppBundle:People');
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

		return new Response('<html><body>'.$return_table.'</body></html>');
	}

	/**
	 *   @Route("/count")
	 **/
	public function TTcount()
	{
		$message = "";
		$collection = $this->get('doctrine_mongodb')->getManager()->getDocumentCollection('TradeTrackerIM\PeopleBundle\Document\dPeople')->find()->count();
		return new Response('<html><body>'.$collection.'</body></html>');
	}

	/**
	 *   @Route("/teardown")
	 **/
	public function TTteardown()
	{
	
		$client = Ec2Client::factory(array( 'credentials' => array( 'key'    => 'AKIAI3JAB55JBACNU2YA', 'secret' => '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',),
                                'profile' => '', 'region'  => 'us-east-1', 'version' => '2015-10-01'));

                        //echo 'If you see this, the number is 1 or below';

			$args = array( 'Filters' => array( array('Name' => 'tag:Master', 'Values' => array('No') )));
			$results = $client->describeInstances($args);
			$reservations = $results['Reservations'];
			foreach ($reservations as $reservation) {
				echo "1->";
    				$instances = $reservation['Instances'];
    				foreach ($instances as $instance) {
					echo "2->";
        				$instanceName = '';
        				foreach ($instance['Tags'] as $tag) {
            					if ($tag['Key'] == 'Name') {
                					$instanceName = $tag['Value'];
							echo $instanceName;
            					}
        				}
					$instance['InstanceId'];
        				$shutdownInstances['InstanceIds'][] = $instance['InstanceId'];
    				}

			}
			$results = $client->stopInstances($shutdownInstances);
                        
		return new Response('<html><body>here it is </body></html>');
	}
}
