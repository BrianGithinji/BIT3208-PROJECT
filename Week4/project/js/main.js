// ── js/main.js ───────────────────────────────────────────────────────────

// Auto-dismiss alert messages after 4 seconds
document.querySelectorAll('.alert').forEach(function (el) {
    setTimeout(function () {
        el.style.transition = 'opacity 0.5s';
        el.style.opacity = '0';
        setTimeout(function () { el.remove(); }, 500);
    }, 4000);
});

// Live session timer — updates the "Session Age" cell every second
var timerCell = document.getElementById('session-timer');
if (timerCell) {
    var seconds = parseInt(timerCell.textContent, 10);
    setInterval(function () {
        seconds++;
        timerCell.textContent = seconds + ' seconds';
    }, 1000);
}

// Password confirmation match indicator on any confirm-password field
var confirmInput = document.getElementById('confirm_password');
var passwordInput = document.getElementById('password');
if (confirmInput && passwordInput) {
    confirmInput.addEventListener('input', function () {
        if (confirmInput.value === '') {
            confirmInput.style.borderColor = '#ddd';
        } else if (confirmInput.value === passwordInput.value) {
            confirmInput.style.borderColor = '#27ae60';
        } else {
            confirmInput.style.borderColor = '#e74c3c';
        }
    });
}
