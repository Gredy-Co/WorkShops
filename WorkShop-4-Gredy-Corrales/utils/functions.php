<?php

define('BASE_URL', '/WorkShop-4-Gredy-Corrales/');



/*
* Connects to the database
*/
function getConnection(): bool|mysqli {
  $connection = mysqli_connect('localhost', 'root', '', 'db_workshop4');
  return $connection;
}



/*
* Gets the provinces from the database
*/
function getProvinces(): array {

  $conn = getConnection();

  $provinces = [];

  if ($conn) {

      $query = "SELECT id_province, province_name FROM provinces";
      $result = mysqli_query($conn, $query);

      if ($result) {

          while ($row = mysqli_fetch_assoc($result)) {
              $provinces[$row['id_province']] = $row['province_name'];  
          }

          mysqli_free_result($result);
      } else {
          echo "Query error: " . mysqli_error($conn);
      }

      mysqli_close($conn);
  } else {
      echo "Connection error: " . mysqli_connect_error();
  }
  return $provinces;
}



/*
* Gets the users from the database
*/
function getUsers(): array {

  $conn = getConnection();

  $users = [];

  if ($conn) {

      $query = "
          SELECT u.id_user, u.first_name, u.last_name, u.username, u.password, u.province_id, p.province_name 
          FROM users u
          JOIN provinces p ON u.province_id = p.id_province
          WHERE u.state_id = 1 
      ";

      $result = mysqli_query($conn, $query);

      if ($result) {

          while ($row = mysqli_fetch_assoc($result)) {
              $users[] = [
                  'id_user'       => $row['id_user'],
                  'first_name'    => $row['first_name'],
                  'last_name'     => $row['last_name'],
                  'username'      => $row['username'],
                  'password'      => $row['password'],
                  'province_id'   => $row['province_id'], 
                  'province_name' => $row['province_name'] 
              ];
          }

          mysqli_free_result($result);
      } else {
          echo "Query error: " . mysqli_error($conn);
      }

      mysqli_close($conn);
  } else {
      echo "Connection error: " . mysqli_connect_error();
  }
  return $users;
}



/*
* Gets a specific user from the database with ID
*/
function getUserById($id_user): array {

  $conn = getConnection();
  $user = [];

  if ($conn) {
      $query = "
          SELECT u.id_user, u.first_name, u.last_name, u.username, u.password, u.province_id, p.province_name 
          FROM users u
          JOIN provinces p ON u.province_id = p.id_province
          WHERE u.id_user = ?
      ";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'i', $id_user); 
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($result) {
          while ($row = mysqli_fetch_object($result)) {
              $user[] = [
                  'id_user'       => $row->id_user,
                  'first_name'    => $row->first_name,
                  'last_name'     => $row->last_name,
                  'username'      => $row->username,
                  'password'      => $row->password,
                  'province_id'   => $row->province_id, 
                  'province_name' => $row->province_name 
              ];
          }

          mysqli_free_result($result);
      } else {
          echo "Query error: " . mysqli_error($conn);
      }

      mysqli_stmt_close($stmt); 
      mysqli_close($conn); 
  } else {
      echo "Connection error: " . mysqli_connect_error();
  }
  return $user;
}



/*
* Check if the email already exists in the database
*/
function emailExists($username): bool {
  $conn = getConnection();

  if ($conn) {
      $query = "SELECT COUNT(*) as count FROM users WHERE username = '" . mysqli_real_escape_string($conn, $username) . "'";
      $result = mysqli_query($conn, $query);

      if ($result) {
          $row = mysqli_fetch_assoc($result);

          mysqli_free_result($result);
          mysqli_close($conn);

          return $row['count'] > 0;
      } else {
          echo "Query error: " . mysqli_error($conn);
      }

      mysqli_close($conn);
  } else {
      echo "Connection error: " . mysqli_connect_error();
  }
  return false;
}



/*
* Saves an specific user into the database
*/
function saveUser($user): bool{

  $first_name   = $user['first_name'];
  $last_name    = $user['last_name'];
  $username     = $user['username'];
  $password     = $user['password'];
  $province     = $user['province'];

  $sql = "INSERT INTO users (first_name, last_name, username, password, province_id) VALUES('$first_name', '$last_name', '$username','$password', '$province')";

  try {
    $conn = getConnection();
    mysqli_query($conn, $sql);
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
  return true;
}



/*
* Updates about an specific user into the database
*/
function updateUser($user, $id_user): bool {

    $first_name  = $user['first_name'];
    $last_name   = $user['last_name'];
    $username    = $user['username'];
    $password    = $user['password'];
    $province    = $user['province'];

    $sql = "UPDATE users SET 
                first_name = '$first_name', 
                last_name = '$last_name', 
                username = '$username', 
                password = '$password', 
                province_id = '$province' 
            WHERE id_user = $id_user";

    try {
        $conn = getConnection();
        mysqli_query($conn, $sql);
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
    return true;
}



/*
* Deletes an specific user into the database
*/
function updateUserState(int $id_user, int $state_id): bool {

    $sql = "UPDATE users SET state_id = '$state_id' WHERE id_user = $id_user";

    try {
        $conn = getConnection(); 
        mysqli_query($conn, $sql); 

        if (mysqli_affected_rows($conn) > 0) {
            return true; 
        } else {
            return false; 
        }
    } catch (Exception $e) {
        echo $e->getMessage(); 
        return false; 
    }
}



/**
 * Get one specific student from the database
 *
 * @id Id of the student
 */
function authenticate($username, $password): bool|array|null{
  $conn = getConnection();
  $sql = "SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password'";
  $result = $conn->query($sql);

  if ($conn->connect_errno) {
    $conn->close();
    return false;
  }

  $results = $result->fetch_assoc();
  $conn->close();

  return $results;
}