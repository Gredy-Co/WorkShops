<?php
require '../utils/functions.php';

if ($_POST && isset($_REQUEST['first_name'])) {
    $id_user            = (int)$_REQUEST['id']; 
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

    $existingUser = getUserById($id_user);
    if (empty($existingUser)) {
        header("Location: ../index.php?error=" . urlencode("User not found."));
        exit;
    }
    
    $existingEmail = $existingUser[0]['username'];

    if ($user['username'] !== $existingEmail && emailExists($user['username'])) {
        header("Location: ../index.php?error=" . urlencode("Email already registered"));
        exit; 
    }

    if (updateUser($user, $id_user)) { 
        header("Location: ../users.php");
    } else {
        header("Location: ../index.php?error=" . urlencode("Invalid user data"));
    }
}
