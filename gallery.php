<?php
session_start();
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gallery</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<body>
 <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project Final</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li class="active"><a href="gallery.php">Gallery</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
<?php
require 'config.php';
$dbh = new PDO($DB['dsn'], $DB['username'], $DB['password']);

$query = 'select * from images';
$stmt = $dbh->prepare($query);
if($stmt->execute()){
	$records = $stmt->fetchAll();
	foreach($records as $value):
	if(isset($_SESSION['email'])):
?>
	<img src="<?=$value['s3_raw_url']?>"/><img src="<?=$value['s3_finished_url']?>"/>
<?php
	else:
?>
	<img src="<?=$value['s3_raw_url']?>"/>
<?php
	endif;
	endforeach;
}else{
	echo 'Failed to execute the query.';
}
?>
</div>
</body>
</html>
