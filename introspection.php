<?php
error_reporting(1);
ini_set('display_errors', 1);
require 'config.php';
require 'vendor/autoload.php';
use Aws\S3\S3Client;

$client = S3Client::factory([
	'version' => 'latest',
	'region' => 'us-west-2',
	'credentials' => [
		'key' => 'xxxx',
		'secret' => 'PMYGeCOhMHai2otgGVXX1/gWDFnbvh/xR1fQ/w0a'
	]
]);

$backupFile = 'mp_' . date('Y-m-d-H-i-s') . '.sql';
$command =  "mysqldump " . $DB['dbname']  . " -h " . $DB['host'] . " -u " . $DB['username'] . " --password=" . $DB['password'];
echo exec($command, $output) . '<br/>';

$output = implode("\n", $output);

$result = $client->putObject([
	'ACL' => 'public-read',
	'Bucket' => 'lukabucket',
	'ContentType' => 'text/sql',
	'Key' => 'backups/' . $backupFile,
	'Body' =>  $output
]);

echo '<a href="' . $result['ObjectURL'] . '" download="' . $backupFile . '">Download</a>';

