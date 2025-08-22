document.addEventListener("DOMContentLoaded", function () {

  window.toggleMobileMenu = function () {
  const mobileMenu = document.getElementById('mobileMenu');
  const hamburger = document.getElementById('hamburgerIcon');
  const overlay = document.getElementById('overlay');

  // Toggle visibility class
  const isOpen = mobileMenu.classList.contains('show');

  if (isOpen) {
    mobileMenu.classList.remove('show');
    overlay.classList.remove('active');
    hamburger.innerHTML = '☰'; // hamburger icon
  } else {
    mobileMenu.classList.add('show');
    overlay.classList.add('active');
    hamburger.innerHTML = '✖'; // close icon
  }
};

   window.toggleSubmenu = function (element) {
  const submenu = element.nextElementSibling;
  submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
};

    window.toggleDropdown = function (el) {
      const dropdown = el.nextElementSibling;
      document.querySelectorAll('.dropdown-content.active').forEach(menu => {
        if (menu !== dropdown) menu.classList.remove('active');
      });
      dropdown.classList.toggle('active');
    };

  });