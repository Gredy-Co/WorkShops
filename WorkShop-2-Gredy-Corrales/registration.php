<?php

include("connection.php");

if (isset($_POST['register']))
{
    if (strlen($_POST['name']) >= 1 &&
        strlen($_POST['lastname']) >= 1 &&
        strlen($_POST['phone']) >= 1 &&
        strlen($_POST['email']) >= 1)

    {
        $name       = trim($_POST['name']);
        $lastname   = trim($_POST['lastname']);
        $phone      = trim($_POST['phone']);
        $email      = trim($_POST['email']);

        $query      = "INSERT INTO `user`(`name`, `lastname`, `phone`, `email`) VALUES ('$name','$lastname', '$phone','$email')";
        $result     =  mysqli_query($connection, $query);

        if ($result) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit();  
        } else {
            ?>
            <h3  class="bad">An error has occurred!</h3>
            <?php
        }
    } else {
        ?>
        <h3 class="bad">Please fill out the fields</h3>
        <?php
    }
}

?>