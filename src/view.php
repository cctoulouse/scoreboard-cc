<?php
	include 'core/config.php';
	session_start();
	
	if($_GET['r'] == "refresh")
	{
		header('Refresh:5; url=view.php?r=refresh');
	}

	$req = $bdd->query('SELECT * FROM groupe ORDER BY score DESC');

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
	<header <?php if($header){?>style="background-image: url('<?php echo $header; ?>');background-position-y: -121px;background-position-x: -239px;"<?php }?>>
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
	        <?php if ($page_points){?><li class="active"><a href="/?r=refresh">Points<span class="sr-only">(current)</span></a></li><?php } ?>
	        <?php if ($page_groupe){?><li><a href="./view.php?r=refresh">Vue Générale</a></li><?php } ?>
	        <?php if ($page_user){?><li><a href="./users.php?r=refresh">Participants</a></li><?php } ?>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="/admin/">Admin</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<div class="container">
			<h1 class="pangolin"><strong>Vue des Groupes</strong></h1><br>
		<?php
			$max_value = 0;
			$i = 0;
			while ($data = $req->fetch())
			{
				$req2 = $bdd->prepare('SELECT * FROM user WHERE groupe = :groupe ORDER BY points DESC');
				$req2->execute(array(":groupe" => $data['id']));
				if ($i % 4 == 0) {
				   if ($i !== 0) {
				      echo "</div>";
				   }
				   echo "<div class='row'>";
				}
		?>
			<div class="col-sm-3">
				<div class="well" style="background-color: #ecf0f1;<?php if($i == 0){echo "border: 3px solid #f1c40f;";} $i++;?>">
				<div class="text-center">
					<h3><?php echo "<strong>N°".$i."  </strong> - ".$data['nom']; ?></h3>
					<h5>Points : <?php if ($i == 1) { $max_value = $data['score'];} echo $data['score']; ?></h5><br>
					<div class="progress bmd-progress">
             		<div class="progress-bar progress-bar-<?php if (((100 * $data['score']) / $max_value) < 30) {echo "danger";} else if(((100 * $data['score']) / $max_value) > 30 && ((100 * $data['score']) / $max_value) < 80) {echo "warning";} else if (((100 * $data['score']) / $max_value) >= 80) {echo "success";} ?>" style="width:<?php echo ((100 * $data['score']) / $max_value); ?>%">
              </div>
          </div>
				</div>
				  <table class="table table-striped">
				    <tbody>
				    <?php
				    	while ($user = $req2->fetch())
				    	{
				    ?>
				      <tr>
				        <td><?php echo ucfirst($user['prenom'])." ".ucfirst($user['nom']); ?></td>
				        <td><?php echo $user['points']; ?></td>
				      </tr>
				      <?php
				  		}
				  	?>
				    </tbody>
				  </table>
				</div>
			</div>
		<?php
		}
		?>
		</div>
		</div>
</body>
</html>