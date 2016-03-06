<?php
namespace Ddns;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Omines\DirectAdmin\DirectAdmin;
use MartinLindhe\MyIp\IpProvider\IpProvider;

class DdnsCommand extends Command {

	protected function configure()
    {
      $this->setName('ddns:refresh')
        ->setDescription('Update DNS record with current IP');
   	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$ipAddress = IpProvider::factory()->getIPv4();

	    $userContext = DirectAdmin::connectAdmin(
	    	'https://'.getenv('DA_HOSTNAME').':'.getenv('DA_PORT'), 
	    	getenv('DA_USERNAME'), 
	    	getenv('DA_PASSWORD'),
	    	true);

	   	$userContext->invokeGet('DNS_CONTROL', [
	    		'domain' => getenv('DOMAIN'),
	    		'action' => 'select',
	    		'arecs0' => 'name='.getenv('DNS_RECORD')
	    	]
	    );

	    $userContext->invokeGet('DNS_CONTROL', [
	    		'domain' => getenv('DOMAIN'),
	    		'action' => 'add',
	    		'type' => 'A',
	    		'name' => getenv('DNS_RECORD'),
	    		'value' => $ipAddress
	    	]
	    );

	    $output->writeln('IP updated to '.$ipAddress);
	}
}