<?php
session_start();
require_once 'connect_Database.php'; // Assuming you have a config file for database connection

// Check if user is logged in
if (!isset($_SESSION['User'])) {
    header("Location: login.php");
    exit();
}

// Check if topic_id or comment_id is set
if (isset($_GET['topic_id'])) {
    $type = 'topic';
    $id = $_GET['topic_id'];
} elseif (isset($_GET['comment_id'])) {
    $type = 'comment';
    $id = $_GET['comment_id'];
} else {
    die("Invalid request: Missing topic_id or comment_id");
}

$user_id = $_SESSION['ID_User'];

// Check if the user has already reported this topic/comment
$check_sql = "SELECT * FROM reports WHERE user_id = ? AND " . $type . "_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $user_id, $id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // User has already reported this topic/comment
    echo "<script>
            alert('You have already reported this " . $type . ".');
            window.history.back();
          </script>";
    $check_stmt->close();
    $conn->close();
    exit();
}
$check_stmt->close();

// Prepare the SQL statement
if ($type === 'topic') {
    $sql = "INSERT INTO reports (user_id, topic_id, report_date) VALUES (?, ?, NOW())";
} else {
    $sql = "INSERT INTO reports (user_id, comment_id, report_date) VALUES (?, ?, NOW())";
}

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $id);

if ($stmt->execute()) {
    // Report submitted successfully
    echo "<script>
            alert('Your report has been submitted successfully.');
            window.history.back();
          </script>";
} else {
    // Error occurred
    echo "<script>
            alert('An error occurred while submitting your report. Please try again.');
            window.history.back();
          </script>";
}

$stmt->close();
$conn->close();