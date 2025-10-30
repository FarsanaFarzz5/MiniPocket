document.addEventListener("DOMContentLoaded", function () {
    const kidProfileToggle = document.getElementById("kidProfileToggle");
    const kidSidebarMenu = document.getElementById("kidSidebarMenu");
    const sidebarOverlay = document.getElementById("sidebarOverlay");

    if (kidProfileToggle && kidSidebarMenu && sidebarOverlay) {
      kidProfileToggle.addEventListener("click", () => {
        kidSidebarMenu.classList.toggle("open");
        sidebarOverlay.classList.toggle("show");
      });

      sidebarOverlay.addEventListener("click", () => {
        kidSidebarMenu.classList.remove("open");
        sidebarOverlay.classList.remove("show");
      });

      document.addEventListener("click", (event) => {
        if (
          !kidSidebarMenu.contains(event.target) &&
          !kidProfileToggle.contains(event.target)
        ) {
          kidSidebarMenu.classList.remove("open");
          sidebarOverlay.classList.remove("show");
        }
      });
    }
  });
