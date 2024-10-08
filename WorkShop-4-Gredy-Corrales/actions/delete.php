<?php
require '../utils/functions.php';

if ($_POST && isset($_REQUEST['id'])) {
    $id_user = (int)$_REQUEST['id'];

    $newState = isset($_REQUEST['new_state']) ? (int)$_REQUEST['new_state'] : 0; 

    $existingUser = getUserById($id_user);
    if (empty($existingUser)) {
        header("Location: ../index.php?error=" . urlencode("User not found."));
        exit;
    }

    if (updateUserState($id_user, $newState)) { 
        header("Location: ../admin.php");
    } else {
        header("Location: ../index.php?error=" . urlencode("Failed to update user state."));
    }
}
?>
