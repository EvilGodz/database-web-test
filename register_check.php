<?php 
    session_start();
    include('connect_Database.php');
    $error = array();

if(isset($_POST['submit'])){
    $Username = mysqli_real_escape_string($conn,$_POST['username']);
    $Email= mysqli_real_escape_string($conn,$_POST['email']);
    $Password= mysqli_real_escape_string($conn,$_POST['password']);
    $RePassword = mysqli_real_escape_string($conn,$_POST['confirm_password']);

    if(empty($Username)){
        array_push($error,'Username is required');
    }
    if(empty($Email)){
        array_push($error,'Email is required');
    }
    if(empty($Password)){
        array_push($error,'Password is required');
    }

    $user_check = "SELECT * FROM users WHERE username = '$Username' OR email = '$Email'";
    $result = $conn->query($user_check);

    if($row = $result->fetch_assoc()){
        if($row['username']=== $Username){
            array_push($error,"Username alredy exists");
        }
        if($row['email']=== $Email){
            array_push($error,"Email alredy exists");
        }
    }
    if(count($error)==0){
       $mdPass = md5($Password);
       $stmt = $conn->prepare("INSERT INTO users(email,username,password) VALUES (?, ?, ?)");
       $stmt->bind_param("sss", $Email, $Username, $mdPass);
       $stmt->execute();
       $user_check = "SELECT user_id FROM users WHERE username = '$Username'";
       $result = $conn->query($user_check);
       $row = $result->fetch_assoc();
       $user_id = $row["user_id"];
       $stmt = $conn->prepare("INSERT INTO user_images(user_id) VALUES (?)");
       $stmt->bind_param("s", $user_id);
       $stmt->execute();
       $_SESSION['username'] = $Username;
       $_SESSION['success'] = "You are now logged in";
       header('location: login.php');

    }else{
        array_push($error,'User or email already exists');
        $_SESSION['error'] = "มีชื่อผู้ใช้หรืออีเมลนี้อยู่แล้ว";
        header('location: register.php');
    }
}

