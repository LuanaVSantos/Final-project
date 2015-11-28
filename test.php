<?php
require 'vendor/autoload.php';
use Aws\Ses\SesClient;

$client = SesClient::factory(array(
	'version' => 'latest',
	'credentials' => array(
		'key' => 'AKIAJPKY6CJYCQADTGGA',
		'secret' => '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'
	),
	'region' => 'us-east-1'
));

try{
$emailSentId = $client->sendEmail([
	'Source' => 'luka.icm@gmail.com',
	'Destination' => ['ToAddresses' => ['kumarbarun89@gmail.com']],
	'Message' => [
		'Subject' => ['Data' => 'test'],
		'Body' => [
			'Text' => ['Data' => 'hi test data']
		]
	]
]);

echo $emailSentId;
}catch(Exception $e){
	echo $e->getMessage();
}

