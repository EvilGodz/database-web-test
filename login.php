<?php
session_start();
require_once 'connect_Database.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="uploads/letter-n.png"type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="javascript/login.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <section>
    <div class="wave wave1"></div>
    <div class="wave wave2"></div>
    <div class="wave wave3"></div>
    <div class="wave wave4"></div>
</section>
    <!-- Box Login -->
    <div class="login-container">
        <div class="login-box">
            <h1 align="center">เข้าสู่ระบบ</h1>

            <!-- From Login -->
            <form action="login_check.php" class="form" method="POST">
                <?php
                include('error.php');
                if (isset($_SESSION['error'])): ?>
                    <div class="error">
                        <h3>
                            <?php echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </h3>
                    </div>
                <?php endif ?>
                <label for="email">ชื่อผู้ใช้หรืออีเมล</label>
                <div class="input-group">
                    <input type="text" id="email" name="Email" placeholder="" required>
                </div>

                <div class="passhi">
                    <label for="password">รหัสผ่าน</label>
                    <div class="password-group">
                        <input type="password" id="password" name="Password" required>
                        <button type="button" id="Hide" aria-label="Toggle password visibility">
                            <i class="fas fa-eye" id="toggle-password"></i> ซ่อนรหัส
                        </button>
                    </div>
                </div>

                <!-- button login -->
                <button type="submit" class="login-btn" name="submit">Login</button>

                <!-- rember, needhelp-->
                <div class="remember-me">
                    <span class="custom-checkbox">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">จดจำฉันไว้</label>
                    </span>
                    <a href="#">ต้องการความช่วยเหลือ?</a>
                </div>

                <!-- learn more  -->
                <div class="captcha-info">
                    ยังไม่มีบัญชีผู้ใช้งาน? <a href="register.php">สมัครสมาชิก</a>
                </div>
                <div class="captcha-info">
                    หน้านี้ได้รับการปกป้องโดย Google ReCAPTCHA เพื่อให้แน่ใจว่าคุณไม่ใช่บอท <a
                        href="#">เรียนรู้เพิ่มเติม</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
</body>

</html>