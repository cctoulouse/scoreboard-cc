<?php
	include '../core/config.php';
	session_start();
	include '../core/verif.php';

	$s = 0;
	if(isset($_POST['submit']))
	{
		if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom'])&& isset($_POST['groupe']) && !empty($_POST['groupe']))
		{

			$groupe = htmlspecialchars($_POST['groupe']);
			$prenom = ucfirst(strtolower(htmlspecialchars($_POST['prenom'])));
			$nom = ucfirst(strtolower(htmlspecialchars($_POST['nom']))); 


			$req1 = $bdd->prepare('SELECT * FROM groupe WHERE nom = :nom');
			$req1->execute(array(":nom" => $groupe));
			$req2 = $req1->fetch();

			$groupe = $req2['id'];

			if ($groupe != NULL)
			{
				$req_add = $bdd->prepare('INSERT INTO user(nom, prenom, groupe) VALUES(:nom, :prenom, :groupe)');
				$req_add->execute(array(
		        	":nom" => $nom,
		        	":prenom" => $prenom,
		        	":groupe" => $groupe
		      		));
				$s = 1;
			}
		}
	}
	$req_group = $bdd->query('SELECT * FROM groupe');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Admin WinterCamp</title>
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
	                 <h1><a href="index.php">Admin WinterCamp</a></h1>
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
                    <li><a href="groupe_add"><i class="glyphicon glyphicon-plus"></i> Ajouter un Groupe</a></li>
                    <li><a href="users_add"><i class="glyphicon glyphicon-plus"></i> Ajouter un utilisateur</a></li>
                    <li class="current"><a href="users_add"><i class="glyphicon glyphicon-plus"></i> Configuration du site</a></li>
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
						<form action="users_add" method="post">
			  				<div class="panel-body">
			  					<div class="form-group">
									<div class="col-md-10">
									<?php
										if ($s == 1)
										{ ?>

										<div class="well">
											<h3><?php echo $prenom." ".$nom; ?> bien ajouté !</h3>
										</div>

									<?php
										}
									?>
										<label class="col-md-2 control-label" for="text-field">Entrez un nom</label>
										<input class="form-control" placeholder="Entrez un nom..." type="text" name="nom">
										<br>
										<label class="col-md-2 control-label" for="text-field">Entrez un prenom</label>
										<input class="form-control" placeholder="Entrez un prenom..." type="text" name="prenom">
										<br>
										<input class="btn btn-primary signup" type="submit" name="submit" value="Ajouter">
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
						<form action="users_add" method="post">
			  				<div class="panel-body">
			  					<div class="form-group">
									<label class="col-md-2 control-label" for="text-field">Nom du Site</label>
									<input class="form-control" placeholder="Entrez un nom..." type="text" name="nom">
									<br>
									<label class="col-md-2 control-label" for="text-field">Lien de l'image</label>
									<input class="form-control" placeholder="Entrez un prenom..." type="text" name="prenom">
									<label class="col-md-6 control-label" for="text-field">Attention vous devez héberger votre image sur NoelShark ou imgur.</label>
									</br>
									<br>
									<input class="btn btn-primary signup" type="submit" name="submit" value="Ajouter">
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