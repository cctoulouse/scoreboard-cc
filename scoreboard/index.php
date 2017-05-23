<?php
	include 'core/config.php';
	session_start();

	if($_GET['r'] == "refresh")
	{
		header('Refresh:5; url=index.php?r=refresh');
	}

	$req = $bdd->query('SELECT * FROM points ORDER BY id DESC');

	/* Get values */
	$req2 = $bdd->query('SELECT * FROM config');
	$i = 0;
	while ($data = $req2->fetch())
	{
		if ($data['name'] == "title"){
			$title = $data['value'];
		}
		if ($data['name'] == "header"){
			$header = $data['value'];
		}
		if ($data['name'] == "flocon" && $data['value'] == "true"){
			$flocon_req = $data['value'];
		}
		if ($data['name'] == "page_points" && $data['value'] == "true"){
			$page_points = $data['value'];
		}
		if ($data['name'] == "page_groupe" && $data['value'] == "true"){
			$page_groupe = $data['value'];
		}
		if ($data['name'] == "page_user" && $data['value'] == "true"){
			$page_user = $data['value'];
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Score | <?php echo $title; ?></title>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/custom.css">
	<script src="assets/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
	<link rel="icon" href="assets/images/favicon.ico" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script src="https://cloud.github.com/downloads/kopipejst/jqSnow/jquery.snow.min.1.0.js"></script>
	<script>
		$(document).ready( function(){
		    $.fn.snow({ minSize: 5, maxSize: 10, newOn: 1000, flakeColor: '#bdc3c7' });
		});
	</script>
</head>
<body>
	<header <?php if($header){?>style="background-image: url('<?php echo $header; ?>');"<?php }?>>
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
	      <a class="navbar-brand" href="#"><?php echo $title; ?></a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <?php if ($page_points){?><li class="active"><a href=".">Points<span class="sr-only">(current)</span></a></li><?php } ?>
	        <?php if ($page_groupe){?><li><a href="/view.php">Vue Générale</a></li><?php } ?>
	        <?php if ($page_user){?><li><a href="/users.php">Participants</a></li><?php } ?>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="/admin/">Admin</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<div class="col-md-12">
		<div class="container">
			<h1 class="pangolin"><strong>Scoreboard <?php echo $title; ?></strong></h1>
			<div class="well">
			<table class="table table-striped">
			    <thead>
			      <tr>
			        <th>Nom Prénom</th>
			        <th>Groupe</th>
			        <th>Points</th>
			        <th>Description</th>
			      </tr>
			    </thead>
			    <tbody>
			    <?php
			    	while ($data = $req->fetch())
			    	{
			    		$req2 = $bdd->prepare('SELECT * FROM user WHERE id = :id');
			    		$req2->execute(array(":id" => $data['id_user']));
			    		$user = $req2->fetch();

			    		$req3 = $bdd->prepare('SELECT * FROM groupe WHERE id = :id');
			    		$req3->execute(array(":id" => $user['groupe']));
			    		$groupe = $req3->fetch();
			    ?>
			      <tr>
			        <td><?php echo ucfirst($user['nom'])." ".ucfirst($user['prenom']); ?></td>
			        <td><?php echo ucfirst($groupe['nom']); ?></td>
			        <td>+<?php echo $data['points']; ?></td>
			        <td><?php echo substr($data['commentaire'],0, 200); ?></td>
			      </tr>
			      <?php
			  		}
			  	?>
			    </tbody>
			  </table>
			</div>
		</div>
	</div>
	<script src="assets/js/bootstrap.min.js"></script>
	<script>
		$(document).ready( function(){
		    $.fn.snow({ minSize: 5, maxSize: 10, newOn: 1000, flakeColor: '#bdc3c7' });
		});
	</script>
</body>
</html>
