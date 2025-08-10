document.addEventListener('DOMContentLoaded', () => {
    // Example JS to auto-dismiss messages after 3s (optional)
    setTimeout(() => {
        document.querySelectorAll('.success, .error').forEach(el => el.style.display = 'none');
    }, 3200);
});
