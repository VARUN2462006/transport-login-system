const menuIcon = document.getElementById('menu-icon');
const menuLinks = document.getElementById('menu-links');
const darkModeToggle = document.getElementById('darkModeToggle');
const profilePhoto = document.getElementById('profile-photo');
const profileName = document.getElementById('profile-name');
const welcomeMessage = document.getElementById('welcome-message');
const phoneLink = document.getElementById('phone-link');
const emailLink = document.getElementById('email-link');

// Sample user data (replace with dynamic data as needed)
const user = {
  username: "To Transport Agency",
  phone: "+919405220xxx",
  email: "athawalevarun1@gmail.com"
};

function updateUserUI(user) {
  profileName.textContent = user.username || 'User';
  welcomeMessage.textContent = `Welcome, ${user.username || 'User'}!`;
  phoneLink.textContent = user.phone || 'N/A';
  phoneLink.href = user.phone ? `tel:${user.phone}` : '#';
  emailLink.textContent = user.email || 'N/A';
  emailLink.href = user.email ? `mailto:${user.email}` : '#';
}

window.addEventListener('load', () => {
  updateUserUI(user);

  // Load dark mode preference
  const darkModeEnabled = localStorage.getItem('dark-mode') === 'enabled';
  applyDarkMode(darkModeEnabled);
});

menuIcon.addEventListener('click', () => {
  menuLinks.classList.toggle('active');
});

document.addEventListener('click', (event) => {
  if (!menuIcon.contains(event.target) && !menuLinks.contains(event.target)) {
    menuLinks.classList.remove('active');
  }
});

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
  if (darkModeToggle.checked) {
    document.body.classList.add('dark-mode');
    localStorage.setItem('dark-mode', 'enabled');
  } else {
    document.body.classList.remove('dark-mode');
    localStorage.setItem('dark-mode', 'disabled');
  }
});