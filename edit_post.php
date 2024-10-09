<?php
session_start();



// Include database connection
require_once 'connect_Database.php';

// Check if post_id is provided
if (!isset($_GET['topic_id'])) {
    header("Location: admin.php?tab=posts");
    exit();
}

$post_id = $_GET['topic_id'];

// Fetch post data
$post = null;
$stmt = $conn->prepare("SELECT topic_id, topic_name, body, topic_date, user_id FROM topics WHERE topic_id = ?");
$stmt->bind_param("i", $post_id);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $post = $row;
    }
    $stmt->close();
}
// Check if the user is logged in as an admin or as a original poster
// if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true || ($idsession != $idtopic)) {
//     header("Location: index.php");
//     exit();
// }
if (!$post) {
    header("Location: admin.php?tab=posts");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic_name = $_POST['topic_name'];
    $body = $_POST['body'];

    $stmt = $conn->prepare("UPDATE topics SET topic_name = ?, body = ? WHERE topic_id = ?");
    $stmt->bind_param("ssi", $topic_name, $body, $post_id);

    if ($stmt->execute()) {
        header("Location: topic.php?topic_id=$post_id");
        exit();
    } else {
        $error = "Error updating post: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
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

        .error-message {
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

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        textarea {
            height: 200px;
        }

        .btn-submit,
        .btn-cancel {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-submit {
            background-color: #3498db;
            color: white;
        }

        .btn-submit:hover {
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
    <header>
        <div class="nav-center">
            แก้ไขโพสต์
        </div>
    </header>

    <div class="admin-container">
        <!-- <p style="font-size: 20px;"><strong>แก้ไขโพสต์ :</strong> <?php echo htmlspecialchars($post['topic_name']); ?></p> -->

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div>
                <label for="topic_name"><strong style="font-size: 20px">หัวข้อ</strong></label>
                <input type="text" id="topic_name" name="topic_name"
                    value="<?php echo htmlspecialchars($post['topic_name']); ?>" required>
            </div>

            <div>
                <label for="body"><strong style="font-size: 20px">เนื้อหา</strong></label>
                <textarea id="body" name="body" required><?php echo htmlspecialchars($post['body']); ?></textarea>
            </div>

            <div>
                <input type="submit" value="อัปเดต" class="btn-submit">
                <?php if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
                    ?><a href="index.php" class="btn-cancel">Cancel</a>
                <?php }
                else echo '<a href="admin.php?tab=posts" class="btn-cancel">ยกเลิก</a>' ?>
            </div>
        </form>
    </div>

    <?php include 'navigation.php' ?>
    <?php include 'background-wrap.html' ?>
</body>

</html>