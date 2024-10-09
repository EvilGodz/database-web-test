document.addEventListener("DOMContentLoaded", () => {
    const editProfileBtn = document.getElementById("editProfileBtn");
    const popup = document.getElementById("popup");
    const closeBtn = document.getElementById("closeBtn");
    const cancelBtn = document.getElementById("cancelBtn");
    const uploadImage = document.getElementById("profileImageInput");
    const imagePreview = document.getElementById("profileImagePreview");
    const form = document.querySelector("#profile-form");

    console.log("JavaScript Loaded");

    editProfileBtn.addEventListener("click", () => {
        console.log("Edit button clicked");
        popup.style.display = "flex";
    });

    closeBtn.addEventListener("click", closePopup);
    cancelBtn.addEventListener("click", closePopup);

    window.addEventListener("click", (event) => {
        if (event.target == popup) {
            closePopup();
        }
    });

    uploadImage.addEventListener("change", (event) => {
        console.log("File input changed");
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = "block";
                console.log("Image loaded successfully");
            }
            reader.readAsDataURL(file);
        } else {
            resetImagePreview();
        }
    });

    function closePopup() {
        popup.style.display = "none";
        form.reset(); // Reset the form when closing
        resetImagePreview();
    }

    function resetImagePreview() {
        imagePreview.src = "<?php echo htmlspecialchars($profile_data['image']); ?>"; // Set to current profile image
        uploadImage.value = "";
    }
});