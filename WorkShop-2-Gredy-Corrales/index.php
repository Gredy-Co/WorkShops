<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"   content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="styles.css">
    <title>User Registration</title>
</head>
<body>
    
    <form method="post" action="">
        <h1>Personal Information</h1>
        <input type="text"      name="name"         placeholder="Name">
        <input type="text"      name="lastname"     placeholder="Last Name">
        <input type="text"      name="phone"        placeholder="Phone Number">
        <input type="email"     name="email"        placeholder="Email">
        <input type="submit"    name="register"     value="Register">

        <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<h3 class='good'>You have registered successfully!</h3>";
        }
        
        ?>
    </form>

    <?php include("registration.php") ?>
    
</body>
</html>
