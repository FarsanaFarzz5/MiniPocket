const amountInput = document.getElementById("amountInput");
const hiddenAmount = document.getElementById("hiddenAmount");
    
const limitNote = document.getElementById("limitNote");

  const successMsg = document.getElementById("successMsg");
  const form = document.querySelector("form");

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    successMsg.style.opacity = "1";
    setTimeout(() => {
      successMsg.style.opacity = "0";
      form.submit(); // continue actual submission after showing message
    }, 1500);
  });
  
    function setAmountBeforeSubmit() {
      const amount = parseInt(amountInput.value) || 0;
      if (amount > 100000) {
        limitNote.style.display = "block";
        return false;
      }
      hiddenAmount.value = amount;
      return true;
    }

    amountInput.addEventListener("input", () => {
      amountInput.style.width = (amountInput.value.length * 22 + 50) + "px";
      if (parseInt(amountInput.value) > 100000) {
        amountInput.value = 100000;
        limitNote.style.display = "block";
      } else {
        limitNote.style.display = "none";
      }
    });

    
