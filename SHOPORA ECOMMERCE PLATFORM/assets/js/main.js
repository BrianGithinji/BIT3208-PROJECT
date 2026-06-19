// Form validation
document.addEventListener('DOMContentLoaded', () => {
    // Bootstrap validation
    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', e => {
            if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
            form.classList.add('was-validated');
        });
    });

    // Password strength indicator
    const pwField = document.getElementById('password');
    const pwStrength = document.getElementById('pw-strength');
    if (pwField && pwStrength) {
        pwField.addEventListener('input', () => {
            const v = pwField.value;
            let strength = 0;
            if (v.length >= 8) strength++;
            if (/[A-Z]/.test(v)) strength++;
            if (/[0-9]/.test(v)) strength++;
            if (/[^A-Za-z0-9]/.test(v)) strength++;
            const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
            const colors = ['', 'danger', 'warning', 'info', 'success'];
            pwStrength.innerHTML = strength > 0
                ? `<small class="text-${colors[strength]}">Strength: ${labels[strength]}</small>` : '';
        });
    }

    // Confirm password match
    const confirm = document.getElementById('confirm_password');
    if (confirm) {
        confirm.addEventListener('input', () => {
            const pw = document.getElementById('password').value;
            confirm.setCustomValidity(confirm.value !== pw ? 'Passwords do not match' : '');
        });
    }

    // Live search filter on catalog
    const searchInput = document.getElementById('live-search');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase();
            document.querySelectorAll('.product-card-wrap').forEach(card => {
                const name = card.dataset.name.toLowerCase();
                card.style.display = name.includes(q) ? '' : 'none';
            });
        });
    }
});

// Cart quantity update
function updateQty(productId, delta) {
    fetch('cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `action=update&product_id=${productId}&delta=${delta}`
    }).then(() => location.reload());
}
