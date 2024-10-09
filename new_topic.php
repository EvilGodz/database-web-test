<?php
$target_dir = "uploads_topic/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$target_file = str_replace(' ', '_', $target_file);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));  

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["image"]["tmp_name"]);
  if ($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  table($target_file);
  header('location: index.php');
  $uploadOk = 0;
}

// Check file size
if ($_FILES["image"]["size"] > 3000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if (
  $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif"
) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    table($target_file);

  }
}

function table($target_file) {
  include 'connect_Database.php';
  session_start();
  $topic= $_POST['topic'];
  $content = $_POST['body'];
  $UserID = $_SESSION['ID_User'];
  $sql = "INSERT INTO topics(topic_name,body,user_id,topic_images) VALUES(?,?,?,?);";
  $user = $conn->execute_query($sql, [$topic, $content, $UserID, $target_file]);
    echo "<script>window.location='index.php'</script>";

}
  mysqli_close($conn);
