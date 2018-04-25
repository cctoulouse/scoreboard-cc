 <?php
      $req = $bdd->prepare('SELECT * FROM user WHERE id = :id');
      $req->execute(array(
            ":id" => $_SESSION['id']
            ));
      $m = $req->fetch();
      if ($m['member_type'] < 2)
            header('Location: ./login.php');
?>