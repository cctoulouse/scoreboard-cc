<?php
      session_start();
      $_SESSION = array();
      setcookie("id", NULL, 1);
      setcookie("mail", NULL, 1);
      setcookie("password", NULL, 1);
      session_destroy();
      header('Location: index.php?r=logout');
?>