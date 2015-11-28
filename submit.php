<?php
session_start();
error_reporting(1);
ini_set("display_errors", 1);

$flag = false;

if($flag){
	if(isset($_SESSION['email'])){
		unset($_SESSION['email']);
	}
	die('Read only mode is turned on. You can\'t upload but view the <a href="gallery.php">gallery</a>.');
}

require 'config.php';
require 'vendor/autoload.php';
use Aws\S3\S3Client;

$client = S3Client::factory(array(
  'version' => 'latest',
  'region' => 'us-west-2',
  'credentials' => array(
	'key'=>'AKIAJPKY6CJYCQADTGGA',
	'secret'=>'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'
  )
));

$bucket_name = 'lukabucket';
//create a bucket if it doesn't exist
if(!$client->doesBucketExist('lukabucket')){
	$client->createBucket(array(
		'Bucket' => $bucket_name
	));
}

$key = 'luka_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

$result = $client->putObject([
	'ACL' => 'public-read',
	'Bucket' => $bucket_name,
	'ContentType' => $_FILES['image']['type'],
	'Key' => $key,
	'SourceFile' => $_FILES['image']['tmp_name']
]);

//poll the object until it is accessible
$client->waitUntil('ObjectExists', array(
	'Bucket' => $bucket_name,
	'Key' => $key
));

$s3_raw_url =  $result['ObjectURL'];

$thumb_result = $client->putObject([
	'ACL' => 'public-read',
	'Bucket' => $bucket_name,
	'ContentType' =>  $_FILES['image']['type'],
	'Key' => 'thubmnail/' . $key,
	'Body' => thumbnailImage($_FILES['image']['tmp_name'])
]);

function thumbnailImage($imagePath){
	$imagick = new \Imagick($imagePath);
	$imagick->thumbnailImage(200, 200, true, true);
	return $imagick->getImageBlob();
}

$uname = $_POST['uname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$s3_finished_url = $thumb_result['ObjectURL'];
$filename = $key;
$status = 1;

//set email to session var to check on gallery.php
$_SESSION['email'] = $email;

$dbh = new PDO($DB['dsn'], $DB['username'], $DB['password']);

$query = 'insert into images(uname, email, phone, s3_raw_url, s3_finished_url, filename, status,  timestamp) values(?, ?, ?, ?, ?, ?, ?, now())';

$stmt = $dbh->prepare($query);
$stmt->bindParam(1, $uname);
$stmt->bindParam(2, $email);
$stmt->bindParam(3, $phone);
$stmt->bindParam(4, $s3_raw_url);
$stmt->bindParam(5, $s3_finished_url);
$stmt->bindParam(6, $filename);
$stmt->bindParam(7, $status);

if($stmt->execute()){
	echo 'Added';
	header('Location: gallery.php');
}else{
	echo 'failed';
}

$dbh = null;

