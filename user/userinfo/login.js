document.getElementById('loginForm').addEventListener('submit', function(e) {
    let username = document.querySelector('input[name="username"]').value.trim();
    let email = document.querySelector('input[name="email"]').value.trim();
    let password = document.querySelector('input[name="password"]').value;
    if (!username || !email || !password) {
        alert('Please fill in all fields.');
        e.preventDefault();
    }
});
