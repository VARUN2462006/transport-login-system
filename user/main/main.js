document.addEventListener('DOMContentLoaded', () => {
  const menuIcon = document.getElementById('menu-icon');
  const menuLinks = document.getElementById('menu-links');
  const darkModeToggle = document.getElementById('darkModeToggle');
  const profilePhoto = document.getElementById('profile-photo');
  const profileName = document.getElementById('profile-name');
  const welcomeMessage = document.getElementById('welcome-message');
  const phoneLink = document.getElementById('phone-link');
  const emailLink = document.getElementById('email-link');

  // Example user data (replace with PHP/session data if you like)
  const user = {
    username: "To Transport Agency",
    phone: "+919405220xxx",
    email: "athawalevarun1@gmail.com"
  };

  function updateUserUI(user) {
    profileName.textContent = user.username || "User";
    welcomeMessage.textContent = `Welcome, ${user.username || "User"}!`;
    phoneLink.textContent = user.phone || "N/A";
    phoneLink.href = user.phone ? `tel:${user.phone}` : "#";
    emailLink.textContent = user.email || "N/A";
    emailLink.href = user.email ? `mailto:${user.email}` : "#";
  }

  // Hamburger menu toggle
  menuIcon.addEventListener('click', (e) => {
    menuLinks.classList.toggle('active');
    e.stopPropagation();
    menuLinks.scrollTop = 0;
  });

  // Keyboard accessibility for hamburger toggle
  menuIcon.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      menuLinks.classList.toggle('active');
      menuLinks.scrollTop = 0;
    }
  });

  // Close menu on outside click or link click
  document.addEventListener('click', (event) => {
    if (!menuLinks.contains(event.target) && !menuIcon.contains(event.target)) {
      menuLinks.classList.remove('active');
    }
    if (event.target.tagName === 'A') {
      menuLinks.classList.remove('active');
    }
  });

  // Dark mode logic
  function applyDarkMode(enabled) {
    if (enabled) {
      document.body.classList.add('dark-mode');
      darkModeToggle.checked = true;
    } else {
      document.body.classList.remove('dark-mode');
      darkModeToggle.checked = false;
    }
  }

  darkModeToggle.addEventListener('change', () => {
    const mode = darkModeToggle.checked ? "enabled" : "disabled";
    applyDarkMode(darkModeToggle.checked);
    localStorage.setItem('dark-mode', mode);
  });

  // Init
  updateUserUI(user);
  const darkModePref = localStorage.getItem('dark-mode');
  applyDarkMode(darkModePref === "enabled");
});