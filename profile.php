<!-- profile.php -->
<?php
include('connect_Database.php');
session_start();

// Improved logout handling
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['User']);
    header('Location: index.php');
    exit();
}

// Sanitize and validate user ID
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : ($_SESSION['ID_User'] ?? null);
if (!$id) {
    // Handle invalid ID, maybe redirect to an error page
    header('Location: error.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์</title>
    <link rel="stylesheet" href="css/idkprofile.css">
    <link rel="icon" href="uploads/letter-n.png"type="image/x-icon"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<body>

<header>
        <div class="nav-center">
            โปรไฟล์
        </div>
    </header>

    <!-- Container for 3 parts -->
    <div class="container">
        <?php include 'navigation.php' ?>

        <!-- Center (Main Content) -->
        <main>
            <!-- Profile  -->
            <?php
            $sql = "SELECT ui.image, u.username, u.user_id, up.firstname, up.lastname, up.bio 
                    FROM user_images ui 
                    INNER JOIN users u ON u.user_id = ui.user_id 
                    LEFT JOIN user_profile up ON u.user_id = up.user_id 
                    WHERE u.user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $row = $result->fetch_assoc()) {
                // Check if user_profile data exists
                if (!$row['firstname'] && !$row['lastname'] && !$row['bio']) {
                    // Insert user_id into user_profile table
                    $insert_sql = "INSERT INTO user_profile (user_id) VALUES (?)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param("i", $id);
                    $insert_stmt->execute();
                    $insert_stmt->close();

                    // Fetch the updated data
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                }
                $profile_data = $row;
                // โปรไฟล์
                ?>
                <div class="profile">
                    <div class="user-info-profile">
                        <img src="<?= $row['image'] ?>" alt="Uploaded Image" class="user-icon" width="100px" height="100px">
                        <div class="user-meta">
                            <div class="user-name">
                                <p style="font-size: 24px;"><strong> User: </strong> <?php echo $row['username']; ?></p>
                                <p style="font-size: 20px;"><strong> ชื่อ: </strong>  <?php echo $row['firstname']; ?></p>
                                <p style="font-size: 20px;"><strong> นามสกุล:</strong>  <?php echo $row['lastname']; ?></p>
                            </div>
                            <div class="user-bio"><?php echo $row['bio']; ?></div>
                        </div>
                    </div>


                    <!-- Button edit กับ logout -->
                    <div class="profile-actions">
                        <!-- ปุ่มสำหรับเปิดโมดัล -->
                        <?php if (isset($_SESSION['ID_User'])){
                        if ($row['user_id'] == $_SESSION['ID_User']) { ?>
                            <button class="edit-button" id="editProfileBtn">แก้ไขโปรไฟล์</button>
                            <a href="logout.php" style="width:100%"><button class="logout-button">Logout</button></a>
                            <!-- เปลี่ยน Follow เป็น Edit Profile -->
                        <?php }}
            } ?>
                    <div>
                    </div>
                </div>

                <!-- content -->

                <?php
                $sql = "SELECT * FROM topics INNER JOIN users ON topics.user_id=users.user_id WHERE topics.user_id=? ORDER BY topic_id DESC LIMIT 20";
                $result = $conn->execute_query($sql, [$id]);
                include 'content.php' ?>
        </main>

        <!-- โมดัล -->
        <div class="popup_addpost" id="myModal_addpost">
            <div class="popup-content_addpost">
                <span class="close_addpost">&times;</span> <!-- ปุ่มปิดป๊อปอัพชิดขวา -->
                <div class="user-info_addpost">
                    <img src="https://cdn-icons-png.flaticon.com/512/2919/2919906.png" alt="Profile Image"
                        class="profile-image_addpost"> <!-- แทนที่ด้วยเส้นทางของรูปโปรไฟล์ -->
                    <h2>ชื่อผู้ใช้</h2>
                </div>

                <!-- เพิ่มช่องกรอกหัวข้อข้อความ -->
                <div class="title-container_addpost">
                    <input type="text" placeholder="หัวข้อข้อความ" class="title-input_addpost">
                </div>

                <div class="textarea-container_addpost"> <!-- แทนที่ textarea ใน div นี้ -->
                    <textarea rows="4" placeholder="กรอกข้อความที่นี่..." class="message-input_addpost"></textarea>
                    <!-- ช่องสำหรับกรอกข้อความ -->
                </div>
                <div class="icon-container_addpost">
                    <img src="icon/camera.svg" alt="Camera Icon" class="icon_addpost">
                    <img src="icon/image.svg" alt="Image Icon" class="icon_addpost">
                    <img src="icon/hash.svg" alt="Hash Icon" class="icon_addpost">
                    <img src="icon/menu.svg" alt="Menu Icon" class="icon_addpost">
                    <button class="btn-post_addpost">โพสต์</button>
                </div>
            </div>
        </div>
        <!-- โมดัลสำหรับแก้ไขรูปภาพ -->
        <div id="popup" class="popup" style="display: none;"> <!-- ซ่อนป๊อปอัปเริ่มต้น -->
            <div class="popup-content">
                <span class="close-btn" id="closeBtn">&times;</span>
                <h2>แก้ไขโปรไฟล์</h2>
                <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="profile-form">
                    <div class="form-group">
                        <label for="firstNameInput">ชื่อ</label>
                        <input type="text" id="firstNameInput" name="firstname"
                            value="<?php echo htmlspecialchars($profile_data['firstname']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastNameInput">นามสกุล</label>
                        <input type="text" id="lastNameInput" name="lastname"
                            value="<?php echo htmlspecialchars($profile_data['lastname']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="bioTextarea">ประวัติย่อ</label>
                        <textarea id="bioTextarea"
                            name="bio"><?php echo htmlspecialchars($profile_data['bio']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="profileImageInput">รูปโปรไฟล์</label>
                        <input type="file" name="image" id="profileImageInput" accept="image/*">
                    </div>
                   <center><img id="profileImagePreview" src="<?php echo htmlspecialchars($profile_data['image']); ?>"
                   alt="Profile Image Preview" class="image-preview"></center> 
                    <div class="form-buttons">
                        <button type="submit" id="submitBtn" name="submit" class="btn-confirm">ยืนยัน</button>
                        <button type="button" id="cancelBtn" class="btn-cancel">ยกเลิก</button>
                    </div>
                </form>

            </div>
        </div>



    </div>
    <script src="javascript/post.js"></script>
    <script src="javascript/profile.js"></script>
    <?php include 'background-wrap.html' ?>
</body>

</html>