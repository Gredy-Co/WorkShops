<?php
require '../utils/functions.php';

if ($_POST && isset($_REQUEST['first_name'])) {
  $user['first_name'] = trim($_REQUEST['first_name']);
  $user['last_name']  = trim($_REQUEST['last_name']);
  $user['username']   = trim($_REQUEST['username']);
  $user['password']   = trim($_REQUEST['password']);
  $user['province']   = trim($_REQUEST['province']);

  $required_fields = ['first_name', 'last_name', 'username', 'password', 'province'];

  foreach ($required_fields as $field) {
    if (empty($user[$field])) {
      header("Location: ../index.php?error=" . urlencode("All fields are required."));
      exit;
    }
  }

  if (emailExists($user['username'])) {
    header("Location: ../index.php?error=" . urlencode("Email already registered"));
    exit; 
  }

  if (saveUser($user)) {
    header( "Location: ../users.php",);
  } else {
    header("Location: ../index.php?error=" . urlencode("Invalid user data"));
  }
}