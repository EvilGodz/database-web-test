<?php
session_start();
require_once 'connect_Database.php';
$error = array();

if (isset($_POST['submit'])) {
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Password = mysqli_real_escape_string($conn, $_POST['Password']);

    if (empty($Email)) {
        array_push($error, "Email is requred");
    }
    if (empty($Password)) {
        array_push($error, "Password is requred");
    }
    if (count($error) == 0) {
        $mdPass = md5($Password);
        $query = "SELECT * FROM users WHERE (email ='$Email' OR username ='$Email') AND password ='$mdPass' ";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION["User"] = $row['username'];
            $_SESSION["ID_User"] = $row['user_id'];
            $_SESSION['admin'] = $row['is_admin'];
            $_SESSION['success'] = "Your are now logged in";
            header('location: index.php');
        } else {
            array_push($error, 'Wrong Email/Password');
            $_SESSION['error'] = "Wrong Email or Password";
            header('location: login.php');
        }
    }
}

