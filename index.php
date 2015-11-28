<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mini Project 2</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<style>
	label{
		display: block;
	}
	</style>
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
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="gallery.php">Gallery</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
<form action="submit.php" method="POST" enctype="multipart/form-data">
<div>
<label>Username*</label>
<input type="text" name="uname" required/>
</div>
<div>
<label>Email*</label>
<input type="text" name="email" required/>
</div>
<div>
<label>Phone</label>
<input type="text" name="phone"/>
</div>
<div>
<label>Image</label>
<input type="file" name="image" required/>
</div>
<br/>
<input type="submit"/>
</form>

<h2>Backup</h2>
<a href="introspection.php">Backup</a>

</div>
</body>
</html>
