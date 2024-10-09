<?php
// like.php
header('Content-Type: application/json');
session_start();
require_once 'connect_Database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic_id = intval($_POST['topic_id']);
    $userId = $_SESSION['ID_User']; // Assuming user ID is stored in session

    // Check if the user has already liked the post
    $stmt = $conn->prepare("SELECT * FROM topic_likes WHERE topic_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $topic_id, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize variables for response
    $userHasLiked = false;

    if ($result->num_rows === 0) {
        // User hasn't liked yet, insert a new like
        $stmt = $conn->prepare("INSERT INTO topic_likes (topic_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $topic_id, $userId);
        $stmt->execute();
        $userHasLiked = true; // Set to true since the user just liked the post
    } else {
        // User already liked, remove like
        $stmt = $conn->prepare("DELETE FROM topic_likes WHERE topic_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $topic_id, $userId);
        $stmt->execute();
        $userHasLiked = false; // Set to false since the user just unliked the post
    }

    // Get the updated like count
    $stmt = $conn->prepare("SELECT COUNT(*) as like_count FROM topic_likes WHERE topic_id = ?");
    $stmt->bind_param("i", $topic_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $likeData = $result->fetch_assoc();

    // Prepare the response
    $response = [
        'like_count' => $likeData['like_count'],
        'user_has_liked' => $userHasLiked
    ];

    echo json_encode($response);
}