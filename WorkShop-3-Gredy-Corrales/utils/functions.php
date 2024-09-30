<?php



/*Connects to the database*/
function getConnection(): bool|mysqli {
  $connection = mysqli_connect('localhost', 'root', '', 'db_workshop3');
  print_r(mysqli_connect_error());
  return $connection;
}



/*Gets the provinces from the database*/
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



/*Gets the users from the database*/
function getUsers(): array {

    $conn = getConnection();

    $users = [];

    if ($conn) {

        $query = "
            SELECT u.id_user, u.first_name, u.last_name, u.email, u.password, u.province_id, p.province_name 
            FROM users u
            JOIN provinces p ON u.province_id = p.id_province
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {

            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = [
                    'id_user'       => $row['id_user'],
                    'first_name'    => $row['first_name'],
                    'last_name'     => $row['last_name'],
                    'email'         => $row['email'],
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



/*Check if the email already exists in the database*/
function emailExists($email): bool {
    $conn = getConnection();

    if ($conn) {
        $query = "SELECT COUNT(*) as count FROM users WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'";
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



/*Saves an specific user into the database*/
function saveUser($user): bool{

  $first_name   = $user['first_name'];
  $last_name    = $user['last_name'];
  $email        = $user['email'];
  $password     = md5($user['password']);
  $province     = $user['province'];

  $sql = "INSERT INTO users (first_name, last_name, email, password, province_id) VALUES('$first_name', '$last_name', '$email','$password', '$province')";

  try {
    $conn = getConnection();
    mysqli_query($conn, $sql);
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
  return true;
}