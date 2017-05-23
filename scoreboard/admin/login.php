<?php
	include '../core/config.php';
	session_start();
	if(isset($_POST['submit']))
	{
		if(isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['password']) && !empty($_POST['password']))
		{
			$mail = htmlspecialchars($_POST['mail']);
			$password = sha1(htmlspecialchars($_POST['password']));

			$req = $bdd->prepare('SELECT * FROM admin WHERE mail = :mail AND password = :password');
			$req->execute(array(":mail" => $mail, ":password" => $password));

			$data = $req->fetch();
			if ($data)
			{
				$_SESSION['id'] = $data['id'];
				$_SESSION['mail'] = $mail;
				$_SESSION['password'] = $password;

				header('Location: ./');
			}
		}
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
  <body class="login-bg">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.php">Admin - <?php echo $title; ?></a></h1>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
			                <h6>Se connecter</h6>
			                <form action="./login.php" method="POST">
				                <input class="form-control" type="text" name="mail" placeholder="E-mail address">
				                <input class="form-control" type="password" name="password" placeholder="Password">
				                <div class="action">
				                    <input type="submit" value="Login" name="submit" class="btn btn-primary signup">
				                </div>
			                </form>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
    <div class="text-center" style="padding-top: 300px;">
	    <a href="../index.php">
	    	<button class="btn btn-success signup">Retour au site...</button>
	    </a>
    </div>
</div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>