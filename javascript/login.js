document.addEventListener('DOMContentLoaded', function () {
    const passwordField = document.getElementById('password');
    const togglePassword = document.getElementById('Hide');
    const toggleIcon = document.getElementById('toggle-password');

    togglePassword.addEventListener('click', function () {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });
});
