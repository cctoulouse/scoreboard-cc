<?php
	include '../core/config.php';
	session_start();
	include '../core/verif.php';

	$all = $bdd->query('SELECT * FROM admin WHERE id ='.$_SESSION['id']);
	$all = $all->fetch();
	$s = 0;
	if(isset($_POST['submit']))
	{
		if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['points']) && !empty($_POST['points']) && isset($_POST['comment']) && !empty($_POST['comment']))
		{

			$points = htmlspecialchars($_POST['points']);
			$comment = htmlspecialchars($_POST['comment']);

			$to_cut = htmlspecialchars($_POST['nom']);

			$to_cut = explode(" ", $to_cut);

			$prenom = $to_cut[0];
			$nom = $to_cut[1];

			$tester = $bdd->prepare('SELECT * FROM user WHERE nom = :nom AND prenom = :prenom');
			$tester->execute(array(":nom" => $nom, ":prenom" => $prenom));

			$data = $tester->fetch();

			if ($data)
			{
				$req_add = $bdd->prepare('INSERT INTO points(id_user, points, commentaire) VALUES(:id_user, :points, :commentaire)');
				$req_add->execute(array(
		        	":id_user" => $data['id'],
		        	":points" => $points,
		        	":commentaire" => $comment
		      		));

				$req_user = $bdd->prepare('UPDATE user SET points = points + :points WHERE id = :id');
				$req_user->execute(array(":points" => $points, ":id" => $data['id']));

				$req_grp = $bdd->prepare('UPDATE groupe SET score = score + :points WHERE id = :id');
				$req_grp->execute(array(":points" => $points, ":id" => $data['groupe']));

				$s = 1;
			}
		}
	}

	$req_name = $bdd->query('SELECT * FROM user');

	/* Get values */
	$req = $bdd->query('SELECT * FROM config');
	$i = 0;
	while ($data = $req->fetch())
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
<html>
  <head>
    <title>Admin - <?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index">Admin - <?php echo $title; ?></a></h1>
	              </div>
	           </div>
	           <div class="col-md-5">
	              <div class="row">
	                <div class="col-lg-12">
	                  <div class="input-group form">
	                  </div>
	                </div>
	              </div>
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                        <li class="dropdown">
	                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Mon compte <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                          <li><a href="logout.php">Déconnexion</a></li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

    <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                <!-- User  -->
                <li><a href="index.php">Bienvenue, <?php echo $_SESSION['mail']; ?></a></li>
                    <!-- Main menu -->
                    <li class="current"><a href="index.php"><i class="glyphicon glyphicon-home"></i> Accueil</a></li>
                    <li><a href="groupe_add.php"><i class="glyphicon glyphicon-plus"></i> Ajouter un Groupe</a></li>
                     <li><a href="users_add.php"><i class="	glyphicon glyphicon-plus"></i> Ajouter un utilisateur</a></li>
					<?php if ($all['type'] > 0){?><li class="current"><a href="config_admin.php"><i class="glyphicon glyphicon-cog"></i> Configuration du site</a></li> <?php } ?>
                    <li><a href="logout.php"><i class="	glyphicon glyphicon-log-out"></i> Déconnexion</a></li>
                  </ul>
             </div>
		  </div>
		  <div class="col-md-10">
		  	<div class="row">
		  		<div class="col-md-12">
		  			<div class="content-box-large">
		  				<div class="panel-heading">
							<div class="panel-title"><b>Ajouter des points</b></div>
						</div>
		  				<div class="panel-body">
		  					<form action="./" method="POST">
			  					<div class="form-group">
									<div class="col-md-10">
									<label class="col-md-2 control-label" for="text-field">Sélectionnez un nom</label>
										<input class="form-control" placeholder="Choisissez une personne..." type="text" list="list" name="nom">
										<datalist id="list">
											<?php 
												while ($liste = $req_name->fetch())
												{
											?>		
											<option value="<?php echo ucfirst($liste['prenom'])." ".ucfirst($liste['nom']); ?>"><?php echo ucfirst($liste['prenom'])." ".ucfirst($liste['nom']); ?></option>
											<?php
												}
											?>
										</datalist> 
										<br>
										<label class="col-md-2 control-label" for="text-field">Nombre de points :</label>
										<input class="form-control" type="number" name="points" placeholder="Entrez un nombre...">
										<br>
										<label class="col-md-2 control-label" for="text-field">Commentaire :</label>
										<input class="form-control" type="text" name="comment" placeholder="Pourquoi donnez vous des points ...">
										<br>
										<input class="btn btn-primary signup" type="submit" name="submit" value="Ajouter">
									</div>
								</div>
							</form>
						</div>
		  			</div>
		  		</div>
		   	</div>
		   	<?php
		   		if ($all['type'] > 0){
		   			?>
		   	<div class="row">
		   		<div class="col-md-12">
					<div class="content-box-large">
		  				<div class="panel-heading">
							<div class="panel-title"><b><i class="fa fa-info"></i>Admin Content</b></div>
						</div>
		  				<div class="panel-body">
		  					<form action="./" method="POST">
			  					<div class="form-group">
									<div class="col-md-10">
									<label class="col-md-2 control-label" for="text-field">Sélectionnez un nom</label>
										<input class="form-control" placeholder="Choisissez une personne..." type="text" list="list" name="nom">
										<datalist id="list">
											<?php 
												while ($liste = $req_name->fetch())
												{
											?>		
											<option value="<?php echo ucfirst($liste['prenom'])." ".ucfirst($liste['nom']); ?>"><?php echo ucfirst($liste['prenom'])." ".ucfirst($liste['nom']); ?></option>
											<?php
												}
											?>
										</datalist> 
										<br>
										<input class="btn btn-primary signup" type="submit" name="submit" value="Ajouter">
									</div>
								</div>
							</form>
						</div>
					</div>
		   		</div>
		   	</div>
		   			<?php
		   		}
		   	?>
		</div>
    </div>

    <footer>
         <div class="container">
         
            <div class="copy text-center">
               Copyright 2014 <a href='#'>Website</a>
            </div>
            
         </div>
      </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>