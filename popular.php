<?php
session_start();
require_once 'connect_Database.php';

// Fetch popular posts (based on like count)
$popular_sql = "SELECT t.*, u.username, ui.image AS user_image, 
                (SELECT COUNT(*) FROM topic_likes WHERE topic_id = t.topic_id) AS like_count
                FROM topics t
                JOIN users u ON t.user_id = u.user_id
                LEFT JOIN user_images ui ON u.user_id = ui.user_id
                ORDER BY like_count DESC
                LIMIT 10";
$popular_result = $conn->query($popular_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โพสต์ยอดนิยม</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" href="uploads/letter-n.png"type="image/x-icon"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
         #heart img {
            filter: grayscale(100%);
            transition: filter 0.3s ease;
        }
        #home img {
            filter: invert(75%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(90%) contrast(95%);
            transition: filter 0.3s ease;
        }

    </style>
</head>
<body>
<?php include 'background-wrap.html' ?>
    <header>
        <div class="nav-center">
        โพสต์ยอดนิยม
        </div>
    </header>

    <!-- Container for 3 parts -->
    <div class="container">
        <?php include 'navigation.php' ?>
        <!-- Center (Main Content) -->
        <main>
            <div class="profile-container">
                <?php
                $result = $popular_result;
                include 'content.php';
                ?>
            </div>
        </main>
    </div>
    <script src="javascript/like.js"></script>
</body>
</html>
