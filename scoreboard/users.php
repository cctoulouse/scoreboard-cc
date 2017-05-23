<?php
	include 'core/config.php';
	session_start();

		if($_GET['r'] == "refresh")
	{
		header('Refresh:5; url=users?r=refresh');
	}

	$req = $bdd->query('SELECT * FROM user ORDER BY points DESC');

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
	<link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
	<link rel="icon" href="assets/images/favicon.ico" />
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
	        <?php if ($page_points){?><li class="active"><a href="./">Points<span class="sr-only">(current)</span></a></li><?php } ?>
	        <?php if ($page_groupe){?><li><a href="./view.php">Vue Générale</a></li><?php } ?>
	        <?php if ($page_user){?><li><a href="./users.php">Participants</a></li><?php } ?>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="/admin/">Admin</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<div class="container">
		<div class="col-sm-12">
			<h1 class="pangolin"><strong>Participants</strong></h1>
			<div class="well">
			<div class="text-center">
				<h3><?php echo $data['nom']; ?></h3>
			</div>
			  <table class="table table-striped">
			    <tbody>
			    <?php
			    $i = 1;
				while ($data = $req->fetch())
				{
					$req2 = $bdd->prepare('SELECT * FROM groupe WHERE id = :id_groupe');
					$req2->execute(array(":id_groupe" => $data['groupe']));
					$groupe = $req2->fetch();
			    ?>
			      <tr <?php if($i<=3){echo "style=\"background-color: rgba(39, 174, 96,0.1);";}if($i==1){echo"border:3px solid rgba(241, 196, 15,1.0);\"";}elseif($i==2){echo"border:3px solid #7f8c8d;\"";}elseif($i==3){echo"border:3px solid #c0392b;\"";}else{echo"\"";}?>>
			        <td><?php echo ucfirst($data['prenom'])." ".ucfirst($data['nom']); ?></td>
			        <td><?php echo $data['points']; ?></td>
			        <td><?php echo $groupe['nom'] ?></td>
			      </tr>
			      <?php
			      $i++;
			  		}
			  		
			  	?>
			    </tbody>
			  </table>
			</div>
		</div>
	</div>
</body>
</html>