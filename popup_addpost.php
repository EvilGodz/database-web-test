<?php 
$sql2 = "SELECT image FROM user_images WHERE user_id =?";
$row2 = $conn->execute_query($sql2, [$_SESSION["ID_User"]])->fetch_assoc(); ?>
<div class="popup_addpost" id="myModal_addpost">
    <div class="popup-content_addpost">
        <form method="POST" action="new_topic.php" enctype="multipart/form-data">
            <span class="close_addpost">&times;</span> <!-- ปุ่มปิดป๊อปอัพชิดขวา -->
            <div class="user-info_addpost">
                <?php $img = $conn->execute_query($sql2, [$_SESSION["ID_User"]])->fetch_assoc(); ?>
                <img src="<?= $img['image'] ?>" alt="Profile Image" class="profile-image_addpost">
                <h2><?php echo $_SESSION['User'] ?></h2>
            </div>

            <!-- เพิ่มช่องกรอกหัวข้อข้อความ -->
            <div class="title-container_addpost">
                <input type="text" placeholder="หัวข้อข้อความ" class="title-input_addpost" name="topic">
            </div>

            <!-- ช่องสำหรับกรอกข้อความ -->
            <div class="textarea-container_addpost">
                <textarea rows="4" placeholder="กรอกข้อความที่นี่..." class="message-input_addpost"
                    name="body""></textarea>
            </div>

            <!-- แสดงพรีวิวรูปภาพ -->
            <div id="preview-container" style="margin-bottom: 20px;display:none">
                <center>
                <img id="image-preview" src="" alt="Image Preview" style="max-width: 500px; max-height: 500px;">
                </center>
            </div>

            <!-- ส่วนสำหรับแนบและพรีวิวรูปภาพ -->
            <div class="icon-container_addpost">
                <img src="icon/camera.svg" alt="Camera Icon" class="icon_addpost">
                <img src="icon/image.svg" alt="Image Icon" class="icon_addpost" id="imageIcon">

                <!-- input สำหรับแนบไฟล์รูปภาพที่ซ่อนไว้ -->
                <input type="file" id="image-upload" name="image" accept="image/*" style="display:none;">

                <img src="icon/hash.svg" alt="Hash Icon" class="icon_addpost">
                <img src="icon/menu.svg" alt="Menu Icon" class="icon_addpost">
                <button class="btn-post_addpost">โพสต์</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript อยู่ที่ท้ายหน้า -->
<script>
    // ฟังก์ชันสำหรับเปิด input เมื่อคลิกที่ไอคอนรูปภาพ
    document.getElementById("imageIcon").addEventListener("click", function () {
        document.getElementById("image-upload").click();  // เปิด input ของไฟล์รูปภาพ
    });

    // ฟังก์ชันสำหรับพรีวิวรูปภาพ
    document.getElementById("image-upload").addEventListener("change", function (event) {
        var file = event.target.files[0]; // ดึงไฟล์จาก input
        var reader = new FileReader();    // ใช้ FileReader เพื่ออ่านไฟล์

        reader.onload = function (e) {
            var previewImage = document.getElementById("image-preview");
            var preview = document.getElementById("preview-container");
            previewImage.src = e.target.result;  // ใส่ URL ของรูปที่อ่านเข้าไปใน src ของ img
            preview.style.display = 'block'; // แสดงภาพพรีวิว
        };

        if (file) {
            reader.readAsDataURL(file);  // ถ้ามีไฟล์ ให้แปลงไฟล์เป็น Data URL แล้วอ่าน
        }
    });
</script>

<!-- ส่วนสำหรับแสดงโพสต์ -->
<div class="posts-container_addpost" id="postsContainer_addpost">
    <!-- โพสต์ใหม่จะถูกเพิ่มที่นี่ -->
</div>
<script src="javascript/post.js"></script>