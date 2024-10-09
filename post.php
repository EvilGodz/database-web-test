<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/post.css"> <!-- เชื่อมโยงกับไฟล์ CSS -->
    <title>ป๊อปอัพโพสต์</title>
</head>
<body>
    <!-- ปุ่มสำหรับเปิดโมดัล -->
    <button id="add">เปิดป๊อปอัพ</button>

    <!-- โมดัล -->
<div class="popup_addpost" id="myModal_addpost">
    <div class="popup-content_addpost">
        <span class="close_addpost">&times;</span> <!-- ปุ่มปิดป๊อปอัพชิดขวา -->
        <div class="user-info_addpost">
            <img src="https://cdn-icons-png.flaticon.com/512/2919/2919906.png" alt="Profile Image" class="profile-image_addpost"> <!-- แทนที่ด้วยเส้นทางของรูปโปรไฟล์ -->
            <h2>ชื่อผู้ใช้</h2> 
        </div>
        
        <!-- เพิ่มช่องกรอกหัวข้อข้อความ -->
        <div class="title-container_addpost">
            <input type="text" placeholder="หัวข้อข้อความ" class="title-input_addpost">
        </div>
        
        <div class="textarea-container_addpost"> <!-- แทนที่ textarea ใน div นี้ -->
            <textarea rows="4" placeholder="กรอกข้อความที่นี่..." class="message-input_addpost"></textarea> <!-- ช่องสำหรับกรอกข้อความ -->
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

<!-- ส่วนสำหรับแสดงโพสต์ -->
<div class="posts-container_addpost" id="postsContainer_addpost">
    <!-- โพสต์ใหม่จะถูกเพิ่มที่นี่ -->
</div>

    <script src="javascript/post.js"></script> <!-- เชื่อมโยงกับไฟล์ JavaScript -->
</body>
</html>
