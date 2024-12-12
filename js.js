// Simulate cart items (this should come from your cart logic)
const cartItems = [
    { name: 'Kebab', price: 5.99, quantity: 2 },
    { name: 'Fries', price: 2.99, quantity: 1 }
];

// Function to display cart items
function displayCartItems() {
    const cartItemsDiv = document.getElementById('cart-items');
    let totalCost = 0;

    cartItems.forEach(item => {
        const itemTotal = item.price * item.quantity;
        totalCost += itemTotal;
        const itemDiv = document.createElement('div');
        itemDiv.innerHTML = `${item.name} - $${item.price.toFixed(2)} x ${item.quantity} = $${itemTotal.toFixed(2)}`;
        cartItemsDiv.appendChild(itemDiv);
    });

    document.getElementById('total-amount').textContent = `$${totalCost.toFixed(2)}`;
}

// Function to handle form submission
function handleFormSubmit(event) {
    event.preventDefault();
    const confirmationMessage = document.getElementById('confirmation-message');
    confirmationMessage.textContent = 'Thank you for your order! Your order has been placed.';
}

// Initialize the page
document.addEventListener('DOMContentLoaded', () => {
    displayCartItems();
    document.getElementById('checkout-form').addEventListener('submit', handleFormSubmit);
});
