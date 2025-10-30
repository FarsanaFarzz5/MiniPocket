
document.addEventListener('DOMContentLoaded', function() {
  const kidMenuToggle = document.getElementById('kidMenuToggle');
  const kidSidebarMenu = document.getElementById('kidSidebarMenu');
  const sidebarOverlay = document.getElementById('sidebarOverlay');

  if (kidMenuToggle && kidSidebarMenu && sidebarOverlay) {
    kidMenuToggle.addEventListener('click', () => {
      const isOpen = kidSidebarMenu.classList.toggle('open');
      sidebarOverlay.classList.toggle('show');
      
      // ✅ Hide the 3 lines when sidebar opens
      if (isOpen) {
        kidMenuToggle.classList.add('hide');
      } else {
        kidMenuToggle.classList.remove('hide');
      }
    });

    sidebarOverlay.addEventListener('click', () => {
      kidSidebarMenu.classList.remove('open');
      sidebarOverlay.classList.remove('show');
      kidMenuToggle.classList.remove('hide');
    });
  }
});
