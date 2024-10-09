<?php
session_start();
include 'connect_Database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="icon" href="uploads/letter-n.png"type="image/x-icon"/>
    <link rel="stylesheet" href="css/register.css"> <!-- Link to your CSS file -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Font Awesome for icons -->
</head>
<body>
<section>
    <div class="wave wave1"></div>
    <div class="wave wave2"></div>
    <div class="wave wave3"></div>
    <div class="wave wave4"></div>
</section>
    <div class="modal-container">
        <?php include('error.php'); ?>
        <form id="form" class="form" Method="POST" action="register_check.php">
            <div class="modal">
                <h1>สมัครสมาชิก</h1>
                <form>
                    <div class="input-group" id="gg">
                        <div class="input-field">
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="error">
                                    <h3>
                                        <?php echo $_SESSION['error'];
                                        unset($_SESSION['error']);
                                        ?>

                                    </h3>
                                </div>
                            <?php endif ?>
                            <label for="username">ชื่อผู้ใช้</label>
                            <input type="text" name="username" id="username" placeholder="" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="email">อีเมล</label>
                        <input type="email" name="email" id="email" placeholder="" required>
                    </div>

                    <div class="input-group">
                        <label for="password">รหัสผ่าน</label>
                        <div class="password-group">
                            <input type="password" name="password" id="password" required>
                            <i class="fas fa-eye" id="toggle-password"></i>
                            </button>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="confirm-password">ยืนยันรหัสผ่าน</label>
                        <div class="password-group">
                            <input type="password" name="confirm_password" id="confirm-password" required>
                            <i class="fas fa-eye" id="toggle-confirm-password"></i>
                            </button>
                        </div>
                    </div>

                    <div class="custom-checkbox">
                        <input type="checkbox" id="agree" name="agree" required>
                        <label for="agree">คุณได้รับทราบและตกลงยอมรับข้อกำหนด
                            และนโยบายที่กำหนดไว้ในนโยบายความเป็นส่วนตัว</label>
                    </div>

                    <button type="submit" class="signup-btn" name="submit">สมัครสมาชิก</button>
                </form>
            </div>
    </div>
</body>
</html>