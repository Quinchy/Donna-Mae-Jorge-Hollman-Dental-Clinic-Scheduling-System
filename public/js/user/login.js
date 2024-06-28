function togglePasswordVisibility(fieldId, icon) {
    var passwordInput = document.getElementById(fieldId);
    var isOpenEye = icon.querySelector('.eye-open');
    var isClosedEye = icon.querySelector('.eye-closed');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        isOpenEye.style.display = 'none';
        isClosedEye.style.display = 'block';
    } else {
        passwordInput.type = 'password';
        isOpenEye.style.display = 'block';
        isClosedEye.style.display = 'none';
    }
}