<?php
	include '../core/config.php';
	session_start();
	include '../core/verif.php';

	$all = $bdd->query('SELECT * FROM admin WHERE id ='.$_SESSION['id']);
	$all = $all->fetch();
	if ($all['type'] < 1)
		header('Location: ./');
	/* Add Staff */
	if (isset($_POST['Ajouter']) && !empty($_POST['Ajouter'])){
		if (isset($_POST['password']) && isset($_POST['email']))
		{
			$req = $bdd->prepare('INSERT INTO admin(mail, password) VALUES(:mail, :password)');
			$req->execute(
				array(
					":mail" => htmlspecialchars($_POST['email']),
					":password" => sha1(htmlspecialchars($_POST['password']))
					));
		}
	}

	/* Delete Staff */
	if (isset($_POST['Supprimer']) && !empty($_POST['Supprimer'])){
		if (isset($_POST['email']))
		{
			$req = $bdd->prepare('DELETE FROM admin WHERE mail = :mail');
			$req->execute(array(
				":mail" => htmlspecialchars($_POST['email_delete'])
				));
		}
	}

	/* Config site */
	if (isset($_POST['submit_site'])){
		if (isset($_POST['title']) && !empty($_POST['title'])){
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => htmlspecialchars($_POST['title']),
				":name" => "title"
				));
		}
		if (isset($_POST['image']) && !empty($_POST['image'])){
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => htmlspecialchars($_POST['image']),
				":name" => "header"
				));
		}
		if (isset($_POST['flocon'])){
			$val = "true";
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => $val,
				":name" => "flocon"
				));
		}
		else
		{
			$val = "false";
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => $val,
				":name" => "flocon"
				));
		}
		if (isset($_POST['page_points'])){
			$val = "true";
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => $val,
				":name" => "page_points"
				));
		}
		else
		{
			$val = "false";
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => $val,
				":name" => "page_points"
				));
		}
		if (isset($_POST['page_groupe'])){
			$val = "true";
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => $val,
				":name" => "page_groupe"
				));
		}
		else
		{
			$val = "false";
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => $val,
				":name" => "page_groupe"
				));
		}
		if (isset($_POST['page_user'])){
			$val = "true";
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => $val,
				":name" => "page_user"
				));
		}
		else
		{
			$val = "false";
			$req = $bdd->prepare('UPDATE config SET value = :value WHERE name = :name');
			$req->execute(array(
				":value" => $val,
				":name" => "page_user"
				));
		}
	}

	if (isset($_POST['submit_total'])){
		$bdd->query('TRUNCATE TABLE points');
		$bdd->query('TRUNCATE TABLE groupe');
		$bdd->query('TRUNCATE TABLE user');
	}

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
	                 <h1><a href="index.php">Admin - <?php echo $title; ?></a></h1>
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
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mon compte <b class="caret"></b></a>
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
                    <!-- Main menu -->
                    <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Accueil</a></li>
                    <li><a href="groupe_add.php"><i class="glyphicon glyphicon-plus"></i> Ajouter un Groupe</a></li>
                    <li><a href="users_add.php"><i class="glyphicon glyphicon-plus"></i> Ajouter un utilisateur</a></li>
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
							<div class="panel-title"><b>Ajouter un Staff Coding Club</b></div>
						</div>
						<form action="config_admin.php" method="post">
			  				<div class="panel-body">
			  					<div class="form-group">
									<div class="col-md-10">
										<label class="col-md-2 control-label" for="text-field">Entrez un email</label>
										<input class="form-control" placeholder="Email..." type="text" name="email">
										<br>
										<label class="col-md-2 control-label" for="text-field">Mot de passe</label>
										<input class="form-control" placeholder="Password..." type="password" name="password">
										<br>
										<input class="btn btn-primary signup" type="submit" name="Ajouter" value="Ajouter">
										<br>
										<br>
										<label class="col-md-2 control-label" for="text-field">Supprimer un compte</label>
										<input class="form-control" placeholder="Email..." type="text" name="email_delete">
										<br>
										<input class="btn btn-danger signup" type="submit" name="Supprimer" value="Supprimer">
									</div>
								</div>
			                </div>
			            </form>  
		  			</div>
		  		</div>

		  		<div class="col-md-12">
		  			<div class="content-box-large">
		  				<div class="panel-heading">
							<div class="panel-title"><b>Configuration du site</b></div>
						</div>
						<form action="config_admin.php" method="post">
			  				<div class="panel-body" >
			  					<div class="form-group">
									<label class="col-md-2 control-label" for="text-field">Nom du Site</label>
									<input class="form-control" placeholder="ex: WinterCamp" type="text" name="title" <?php if ($title){echo "value=\"".$title."\"";} ?>>
									<br>
									<label class="col-md-2 control-label" for="text-field">Image header</label>
									<input class="form-control" placeholder="ex: http://noway.fr/trancoso.png" type="text" name="image" <?php if ($header){echo "value=\"".$header."\"";} ?>>
									<label class="col-md-6 control-label" for="text-field">Attention vous devez héberger votre image sur NoelShark ou imgur.</label>
									</br>
									<br>
									<label class="form-check-label">
									    <input class="form-check-input" type="checkbox" name="flocon" <?php if ($flocon_req){echo "checked";} ?>>
									    Option bonus : Chute de flocons
									</label>
									</br>
									<br>
									<div class="panel-body" style="background-color:#eff0f3">
									<label> Gestion des pages : </label>
									<br>
									<label class="form-check-label">
									    <input class="form-check-input" type="checkbox" name="page_points" <?php if ($page_points){echo "checked";} ?>>
									    Derniers points ajoutés
									</label>
									<br>
									<label class="form-check-label">
									    <input class="form-check-input" type="checkbox" name="page_groupe" <?php if ($page_groupe){echo "checked";} ?>>
									    Vue de groupes (si vous avez des groupes : cochez la case)
									</label>
									<br>
									<label class="form-check-label">
									    <input class="form-check-input" type="checkbox" name="page_user" <?php if ($page_user){echo "checked";} ?>>
									    Vue par utilisateur
									</label>
									</div>
									<br>
									<br>
									<input class="btn btn-primary signup" type="submit" name="submit_site" value="Mettre à jour le site">
								</div>
			                </div>
			            </form>  
		  			</div>
		  		</div>

		  		<div class="col-md-12">
		  			<div class="content-box-large">
		  				<div class="panel-heading">
							<div class="panel-title"><b>Réinitialisation du site</b></div>
						</div>
						<form action="config_admin.php" method="post">
			  				<div class="panel-body">
			  					<div class="form-group">
									<div class="col-md-10">
									<label> Option de réinitialisation : </label>
									<br class="form-check">
									<div>
									<br>
									<input class="btn btn-danger signup" type="submit" name="submit_total" value="Supprimer les utilisateurs et les points">
								</div>
									</div>
								</div>
			                </div>
			            </form>  
		  			</div>
		  		</div>

		   	</div>
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