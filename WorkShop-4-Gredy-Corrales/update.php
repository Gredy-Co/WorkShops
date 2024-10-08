<?php
    require_once('utils/functions.php');
    if (isset($_GET['id'])) {
        $id_user = (int)$_GET['id'];
        $user = getUserById($id_user);
        
        if (empty($user)) {
            die("User not found.");
        } else {
            $us = $user[0]; 
        }
    }
?>

<?php
    require_once('utils/functions.php');
    $provinces = getProvinces();
    $error_msg = '';
    if(isset($_GET['error'])) {
        $error_msg = $_GET['error'];
    }
?>

<?php require('inc/header.php')?>
<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="display-4">Update User</h1>
        <p class="lead">This is the update process</p>
        <hr class="my-4">
    </div>

    <form method="post" action="actions/update.php">
        <?php if ($error_msg): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?php echo $us['id_user']; ?>">

        <div class="form-group">
            <label for="first-name">First Name</label>
            <input id="first-name" class="form-control" type="text" name="first_name" value="<?php echo htmlspecialchars($us['first_name']); ?>">
        </div>
        <div class="form-group">
            <label for="last-name">Last Name</label>
            <input id="last-name" class="form-control" type="text" name="last_name" value="<?php echo htmlspecialchars($us['last_name']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($us['username']); ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" class="form-control" type="password" name="password" value="<?php echo htmlspecialchars($us['password']); ?>">
        </div>
        <div class="form-group">
            <label for="province">Provincia</label>
            <select id="province" class="form-control" name="province">
                <?php foreach($provinces as $id => $province): ?>
                    <option value="<?php echo $id; ?>" <?php echo ($id == $us['province_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($province); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary"> Update User </button> 
    </form>
    <a href="users.php" class="btn btn-secondary mt-3">View Users</a>
</div>
<?php require('inc/footer.php'); ?>
