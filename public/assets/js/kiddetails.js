
 
    document.addEventListener("DOMContentLoaded", () => {
      const cards = document.querySelectorAll(".kid-card");

      cards.forEach((card) => {
        card.addEventListener("click", () => {
          const index = card.dataset.index;
          const clickedDetails = document.getElementById("details-" + index);
          const isVisible = clickedDetails.style.display === "block";

          document.querySelectorAll(".details").forEach((d) => d.style.display = "none");
          cards.forEach((c) => c.classList.remove("active"));

          if (!isVisible) {
            clickedDetails.style.display = "block";
            card.classList.add("active");
          }
        });
      });
    });
