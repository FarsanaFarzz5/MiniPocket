
const kidsToggle = document.getElementById("kidsMenuToggle");
const kidsSubmenu = document.getElementById("kidsSubmenu");

kidsToggle.addEventListener("click", (e) => {
  e.preventDefault(); e.stopPropagation();
  kidsSubmenu.classList.toggle("show");
});
document.addEventListener("click", (e) => {
  if (!kidsToggle.contains(e.target)) {
    kidsSubmenu.classList.remove("show");
  }
});

  document.querySelectorAll(".kids-submenu a").forEach(link => {
    link.addEventListener("click", (e) => {
      e.stopPropagation(); // Prevent toggle handler from firing
      kidsSubmenu.classList.remove("show"); // Hide submenu after click
    });
  });
