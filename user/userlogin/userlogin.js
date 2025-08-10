document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!email || !username || !password) {
        e.preventDefault();
        alert("Please fill all fields.");
    }
    document.addEventListener("DOMContentLoaded", () => {
    console.log("User login page loaded");
});

