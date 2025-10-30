   function toggleDetails(index) {
      const clicked = document.getElementById('details-' + index);
      const isVisible = clicked.style.display === 'block';
      document.querySelectorAll('.details').forEach(d => d.style.display = 'none');
      if (!isVisible) clicked.style.display = 'block';
    }