<?php
  require('../utils/functions.php');

  if($_POST) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $user = authenticate($username, $password);

    if($user) {
      session_start();
      $_SESSION['user'] = $user;
  
      if ($user['rol_id'] == 1) {
        header('Location: /WorkShop-4-Gredy-Corrales/admin.php'); 
      } else {
        header('Location: /WorkShop-4-Gredy-Corrales/user.php'); 
      }
    } else {
      header('Location: ../index.php?error=error');
    }
  }