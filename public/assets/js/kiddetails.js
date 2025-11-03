   function toggleDetails(index) {
      const clicked = document.getElementById('details-' + index);
      const isVisible = clicked.style.display === 'block';
      document.querySelectorAll('.details').forEach(d => d.style.display = 'none');
      if (!isVisible) clicked.style.display = 'block';
    }

    document.querySelectorAll('.kid-card').forEach(card => {
    card.addEventListener('click', () => {
      // toggle the active highlight
      card.classList.toggle('active');

      // toggle the corresponding details box (next sibling element)
      const details = card.nextElementSibling;
      if (details && details.classList.contains('details')) {
        details.style.display = details.style.display === 'block' ? 'none' : 'block';
      }

      // hide all other details & remove highlight from other cards
      document.querySelectorAll('.kid-card').forEach(other => {
        if (other !== card) {
          other.classList.remove('active');
          const otherDetails = other.nextElementSibling;
          if (otherDetails && otherDetails.classList.contains('details')) {
            otherDetails.style.display = 'none';
          }
        }
      });
    });
  });