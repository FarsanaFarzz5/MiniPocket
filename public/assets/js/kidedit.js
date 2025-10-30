
  function openFilePicker(e) {
    e.stopPropagation();
    document.getElementById('profile_img').click();
  }

  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
      document.getElementById('profileImage').src = reader.result;
      document.getElementById('updateBtn').classList.add('show');
    };
    reader.readAsDataURL(event.target.files[0]);
  }

  document.addEventListener('DOMContentLoaded', function() {
    const kidMenuToggle = document.getElementById('kidMenuToggle');
    const kidSidebarMenu = document.getElementById('kidSidebarMenu');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (kidMenuToggle && kidSidebarMenu && sidebarOverlay) {
      kidMenuToggle.addEventListener('click', () => {
        kidSidebarMenu.classList.toggle('open');
        sidebarOverlay.classList.toggle('show');
      });

      sidebarOverlay.addEventListener('click', () => {
        kidSidebarMenu.classList.remove('open');
        sidebarOverlay.classList.remove('show');
      });
    }
  });
