const menuToggle = document.getElementById("menuToggle");
const sidebarMenu = document.getElementById("sidebarMenu");
const sidebarOverlay = document.getElementById("sidebarOverlay");

  // Sidebar toggle
  menuToggle.addEventListener("click", () => {
    menuToggle.classList.toggle("active");
    sidebarMenu.classList.toggle("open");
    sidebarOverlay.classList.toggle("show");
  });

  // Overlay click closes sidebar
  sidebarOverlay.addEventListener("click", () => {
    sidebarMenu.classList.remove("open");
    menuToggle.classList.remove("active");
    sidebarOverlay.classList.remove("show");
  });

  // Dropdown toggle
  document.querySelectorAll(".dropdown-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const parent = btn.parentElement;
      parent.classList.toggle("open");
    });
  });