<?php
  session_start();
  include('connect_Database.php');
  $topic_id = $_POST['topic_id'];
  $comment = $_POST['comment'];
  $UserID = $_SESSION['ID_User'];
  $sql = "INSERT INTO comments(comment,user_id,topic_id) VALUES(?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $comment, $UserID, $topic_id);
  $stmt->execute();
