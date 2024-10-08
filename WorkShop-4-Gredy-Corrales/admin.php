<?php
  include('utils/functions.php');
  $users = getUsers();
  $error_msg = '';
  if(isset($_GET['error'])) {
    $error_msg = $_GET['error'];
  }
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="css/styles.css"> 
<script src="https://kit.fontawesome.com/12d578a4cd.js" crossorigin="anonymous"></script>

<?php require('inc/header.php')?>
<div class="container mt-5">
    <div class="jumbotron text-center">
      <h1 class="display-4">Administration</h1>
      <p class="lead">Here is a list of all registered users.</p>
      <hr class="my-4">
      <a href="index.php" class="btn btn-primary">Go to Log In</a>
      <a href="signup.php" class="btn btn-primary">Go to Sign Up</a>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
          <?php
              if (!empty($users)) {
                foreach ($users as $user) { ?>
                    <tr>
                        <td><?= $user['id_user'] ?></td>
                        <td><?= $user['first_name'] ?></td>
                        <td><?= $user['last_name'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['password'] ?></td>
                        <td><?= $user['province_name'] ?></td>
                        <td class="text-center">
                            <a href="<?php echo BASE_URL; ?>update.php?id=<?= $user['id_user'] ?>" class="btn btn-edit" title="Edit">
                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </a>
                            <form action="<?php echo BASE_URL; ?>actions/delete.php" method="POST" style="display:inline;" title="Delete">
                                <input type="hidden" name="id" value="<?= $user['id_user'] ?>">
                                <input type="hidden" name="new_state" value="2"> 
                                <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">
                                    <i class="fa-solid fa-trash fa-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php }  
              } 
            ?>
        </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</div>
<?php require('inc/footer.php'); ?>
