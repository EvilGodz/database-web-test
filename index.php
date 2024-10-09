<?php
require_once 'connect_Database.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแรก</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" href="uploads/letter-n.png"type="image/x-icon"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
<?php include 'background-wrap.html' ?>
    </div>
    <header>
        <div class="nav-center">
            NIMBUS
        </div>
    </header>

    <!-- Container for 3 parts -->
    <div class="container">
        <?php include 'navigation.php' ?>
        <!-- Center (Main Content) -->
        <main>
            <!-- Profile content here -->
            <div class="profile-container">
                <!-- Post 1 -->
                <?php
                $sql = "SELECT * FROM topics INNER JOIN users ON topics.user_id=users.user_id ORDER BY topic_id DESC LIMIT 20";
                $result = $conn->execute_query($sql);
                include 'content.php'?>
            </div>
        </main>
    </div>
</body>

</html>