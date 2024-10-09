<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header("Location: login.php");
    exit();
}

require_once 'connect_Database.php';

if (isset($_GET['user_id'])) {
    $id = intval($_GET['user_id']);
    
    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete reports
        $stmt = $conn->prepare("DELETE FROM reports WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Delete comments
        $stmt = $conn->prepare("DELETE FROM comments WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Delete likes
        $stmt = $conn->prepare("DELETE FROM topic_likes WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Delete topics
        $stmt = $conn->prepare("DELETE FROM topics WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Delete user profile
        $stmt = $conn->prepare("DELETE FROM user_profile WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Delete user images
        $stmt = $conn->prepare("DELETE FROM user_images WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Delete user
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();
        $_SESSION['message'] = "User and all related data deleted successfully.";
    } catch (Exception $e) {
        // Rollback the transaction if an error occurred
        $conn->rollback();
        $_SESSION['message'] = "Error deleting user and related data: " . $e->getMessage();
    }
} else {
    $_SESSION['message'] = "Invalid user ID.";
}

header("Location: admin.php");
exit();