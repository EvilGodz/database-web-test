<div class="sidebar-icons">
    <div class="icon" id="home">
        <a href="index.php"><img src="icon/home.svg" alt="Home Icon"></a>
    </div>
    <div class="icon" id="search">
        <a href="search.php"><img src="icon/Search.svg" alt="Search Icon"></a>
    </div>
    <?php if (isset($_SESSION['User'])): ?>
        <div class="icon" id="add">
            <img src="icon/Add.svg" alt="Add Icon">
        </div>
    <?php endif ?>
    <div class="icon" id="heart">
        <a href="popular.php"><img src="icon/Heart.svg" alt="Heart Icon"></a>
    </div>
    <div class="icon" id="profile">
        <?php if (isset($_SESSION['User'])): ?>
            <a href="profile.php"><img src="icon/Profile.svg" alt="Profile Icon"></a>
        <?php else: ?>
            <a href="login.php"><img src="icon/Profile.svg" alt="Profile Icon"></a>
        <?php endif ?>
    </div>
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {?>
        <div class="icon" id="admin">
            <a href="admin.php"><img src="icon/settings.svg" alt="Admin Icon"></a>
        </div>
        <?php
    }
    ?>
</div>

<?php if (isset($_SESSION['User'])): ?>
    <?php include("popup_addpost.php"); ?>
<?php endif ?>