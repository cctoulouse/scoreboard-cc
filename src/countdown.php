<?php
	include 'core/config.php';
	session_start();

	$req = $bdd->query('SELECT * FROM groupe ORDER BY score DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Score | Winter Camp</title>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/custom.css">
	<link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
	<link rel="icon" href="assets/images/favicon.ico" />
</head>
<body>
	<header>
		<div class="text-center" style="padding-top:25px">
			<img src="assets/images/cobra.png">
		</div>
	</header>
	<nav class="nav nav-default custom-nav">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Winter Camp</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="./">Points<span class="sr-only">(current)</span></a></li>
	        <li><a href="#">Vue Générale</a></li>
	        <li><a href="./users.php">Participants</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="/admin/">Admin</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<div class="container">
			<h1 class="pangolin"><strong>Compte à rebours</strong></h1><br>
		</div>
		<iframe width="100%" height="400px" src="https://www.watchisup.fr/compte-a-rebours/embed/winter-camp-2017-02-17-11-00?backgroundcolor=&color=" frameborder="0" allowfullscreen></iframe>
					<h2>Critère secret: les cobras aiment la fête foraine !</h2>
		</div>
</body>
</html>