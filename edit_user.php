<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'connect_Database.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id === 0) {
    // Handle invalid user ID
    header("Location: admin.php?tab=users");
    exit();
}

// Fetch user data
$user = null;
$stmt = $conn->prepare("SELECT users.*, user_images.image FROM users LEFT JOIN user_images ON users.user_id = user_images.user_id WHERE users.user_id = ?");
$stmt->bind_param("i", $user_id);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

if (!$user) {
    // Handle user not found
    header("Location: admin.php?tab=users");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    $new_password = $_POST['new_password'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Update user information
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, is_admin = ? WHERE user_id = ?");
        $stmt->bind_param("ssii", $username, $email, $is_admin, $user_id);
        $stmt->execute();

        // Update password if provided
        if (!empty($new_password)) {
            $hashed_password = md5($new_password);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $stmt->bind_param("si", $hashed_password, $user_id);
            $stmt->execute();
        }

        // Handle image upload
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file type
            if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                    // Update or insert image path in database
                    $stmt = $conn->prepare("INSERT INTO user_images (user_id, image) VALUES (?, ?) ON DUPLICATE KEY UPDATE image = ?");
                    $stmt->bind_param("iss", $user_id, $target_file, $target_file);
                    $stmt->execute();
                }
            }
        }

        // Commit transaction
        $conn->commit();

        // Redirect back to admin page with success message
        header("Location: admin.php?tab=users&message=User updated successfully");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $error = "Error updating user: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
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

        .profile-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<?php include 'background-wrap.html' ?>
    <header>
        <div class="nav-center">
            Edit User
        </div>
    </header>

    <div class="admin-container">
        <h1>Edit User: <?php echo htmlspecialchars($user['username']); ?></h1>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <img src="<?php echo $user['image'] ?? 'images/default_profile.png'; ?>" alt="Profile Image" class="profile-image">
                <label for="profile_image">Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*">
            </div>
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div>
                <label for="new_password">New Password (leave blank to keep current):</label>
                <input type="password" id="new_password" name="new_password">
            </div>
            <div>
                <label for="is_admin">
                    <input type="checkbox" id="is_admin" name="is_admin" <?php echo $user['is_admin'] ? 'checked' : ''; ?>>
                    Admin
                </label>
            </div>
            <div>
                <button type="submit">Update User</button>
                <a href="admin.php?tab=users" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

    <?php include 'navigation.php' ?>
</body>
</html>