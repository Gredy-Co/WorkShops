<?php
  include('utils/functions.php');
  $users = getUsers();
  $error_msg = '';
  if(isset($_GET['error'])) {
    $error_msg = $_GET['error'];
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> 
</head>

<body>
  <div class="container mt-5">

    <div class="jumbotron text-center">
      <h1 class="display-4">Users List</h1>
      <p class="lead">Here is a list of all registered users.</p>
      <hr class="my-4">
      <a href="index.php" class="btn btn-primary">Go to Sign Up</a>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID User</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Province</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if (!empty($users)) {
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . $user['id_user'] . "</td>";
                        echo "<td>" . $user['first_name'] . "</td>";
                        echo "<td>" . $user['last_name'] . "</td>";
                        echo "<td>" . $user['email'] . "</td>";
                        echo "<td>" . $user['password'] . "</td>";
                        echo "<td>" . $user['province_name'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No users found.</td></tr>";
                }
            ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
