
let quantity = 1;

function changeQuantity(value) {
  quantity += value;
  if (quantity < 1) {
    quantity = 1;
  }
  updateDisplay();
}

function updateDisplay() {
  const quantityDisplay = document.querySelector('.quantity-display');
  quantityDisplay.textContent = quantity;
}