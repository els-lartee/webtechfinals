document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(function () {
            window.location.href = 'login.php';
        }, 2000);
    }
});