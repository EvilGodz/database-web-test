<?php
session_start();

// Check if the user is logged in as an admin
// if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
//     header("Location: login.php");
//     exit();
// }

// Include database connection
require_once 'connect_Database.php';

$comment_id = isset($_GET['comment_id']) ? intval($_GET['comment_id']) : 0;

if ($comment_id === 0) {
    // Handle invalid comment ID
    header("Location: admin.php?tab=comments");
    exit();
}

// Fetch comment data
$comment = null;
$stmt = $conn->prepare("SELECT c.comment_id, c.comment, c.user_id, c.topic_id, u.username 
                        FROM comments c 
                        INNER JOIN users u ON c.user_id = u.user_id 
                        WHERE c.comment_id = ?");
$stmt->bind_param("i", $comment_id);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $comment = $result->fetch_assoc();
    $stmt->close();
}

if (!$comment) {
    // Handle comment not found
    header("Location: admin.php?tab=comments");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_comment = trim($_POST['comment']);
    
    if (empty($new_comment)) {
        $error = "Comment cannot be empty.";
    } else {
        $stmt = $conn->prepare("UPDATE comments SET comment = ? WHERE comment_id = ?");
        $stmt->bind_param("si", $new_comment, $comment_id);
        if ($stmt->execute()) {
            // Redirect back to admin page with success message
            header("Location: admin.php?tab=comments&message=Comment updated successfully");
            exit();
        } else {
            $error = "Error updating comment: " . $conn->error;
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" href="uploads/letter-n.png"type="image/x-icon"/>
    <style>
        .admin-container {
            max-width: 800px;
            margin: 80px auto 0;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        form div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            resize: vertical;
            min-height: 100px;
        }

        button[type="submit"],
        .btn-cancel {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"] {
            background-color: #3498db;
            color: white;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        .btn-cancel {
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }

        .btn-cancel:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
<?php include 'background-wrap.html' ?>
    <header>
        <div class="nav-center">
            แก้ไข คอมเมนต์ 
        </div>
    </header>

    <div class="admin-container">
        <p style="font-size: 25px; font-stley">แก้ไข คอมเมนต์</p>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div>
                <!-- <label for="comment">Comment:</label> -->
                <textarea id="comment" name="comment" required><?php echo htmlspecialchars($comment['comment']); ?></textarea>
            </div>
            <div>
                <label>ผู้เขียน : <?php echo htmlspecialchars($comment['username']); ?></label>
            </div>
            <div>
                <label>Topic ID: <?php echo htmlspecialchars($comment['topic_id']); ?></label>
            </div>
            <div>
                <button type="submit">อัปเดต</button>
                <?php if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
                    ?><a href="index.php" class="btn-cancel">Cancel</a>
                <?php }
                else echo '<a href="admin.php?tab=comments" class="btn-cancel">ยกเลิก</a>' ?>
            </div>
        </form>
    </div>

    <?php include 'navigation.php' ?>
</body>
</html>
