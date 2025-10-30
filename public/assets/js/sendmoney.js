const searchInput = document.getElementById('searchInput');
const kidList = document.getElementById('kidList');
searchInput.addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const kids = kidList.getElementsByClassName('kid-card');
      Array.from(kids).forEach(kid => {
        const name = kid.textContent.toLowerCase();
        kid.style.display = name.includes(filter) ? '' : 'none';
      });
    });
