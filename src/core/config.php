<?php
      $dbname = "scoreboard";
      $dbuser = "root";
      $dbpass = "passroot";
      $dbhost = $_ENV["MYSQL_PORT_3306_TCP_ADDR"];

      session_start();
      try
      {
            $bdd = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset=utf8', $dbuser, $dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      }
      catch(Exception $e)
      {
            die('Erreur: ' . $e->getMessage());      
      }
?>