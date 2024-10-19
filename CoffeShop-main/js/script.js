
// Navbar toggle
let navbar = document.querySelector('.navbar');

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');
}

let searchForm = document.querySelector('.search-form');

document.querySelector('#search-btn').onclick = () => {
    searchForm.classList.toggle('active');
    navbar.classList.remove('active');
    cartItem.classList.remove('active');
}

let cartItem = document.querySelector('.cart-items-container');

document.querySelector('#cart-btn').onclick = () => {
    cartItem.classList.toggle('active');
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
}

// Favorite item toggle
let favorite = document.querySelector('.favorite-items-container');

document.querySelector('#favorite').onclick = () => {
    favorite.classList.toggle('active');
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
}

// Close the cart when clicking outside of it
document.addEventListener('click', (event) => {
    const isClickInsideCart = cartItem.contains(event.target);
    const isCartButton = document.querySelector('#cart-btn').contains(event.target);

    if (!isClickInsideCart && !isCartButton) {
        cartItem.classList.remove('active');
    }
});

// Initialize cart if not present in localStorage
if (!localStorage.getItem('cart')) {
    localStorage.setItem('cart', JSON.stringify([]));
}

// Add to cart function
function addToCart(id, name, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart'));
    let existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        alert('This item is already in your cart!');
        return;
    }

    cart.push({ id, name, price, image });
    alert('Successfully Added!');
    localStorage.setItem('cart', JSON.stringify(cart));
    loadFavItems();
}

// Load cart items to display in the cart section
function loadFavItems() {
    let cart = JSON.parse(localStorage.getItem('cart'));
    let cartContainer = document.querySelector('.cart-items-container');
    
    cartContainer.innerHTML = '';
    let totalPrice = 0;

    cart.forEach(item => {
        let cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        let quantityInputId = `quantity-${item.id}`;

        cartItem.innerHTML = `
            <span class="fas fa-times" onclick="removeFromCart('${item.id}')"></span>
            <img src="${item.image}" alt="">
            <div class="content">
                <h3>${item.name}</h3>
                <div class="price">$${item.price.toFixed(2)}</div>
                <label for="${quantityInputId}">Quantity:</label>
                <input type="number" id="${quantityInputId}" min="1" value="1" onchange="updateTotalPrice()">
            </div>
        `;
        cartContainer.appendChild(cartItem);

        let quantity = parseInt(document.getElementById(quantityInputId).value) || 1;
        totalPrice += item.price * quantity;
    });

    let orderSection = document.createElement('div');
    orderSection.classList.add('order-section');
    orderSection.innerHTML = `
        <div class="total-price-display"><strong>Total Price: $${totalPrice.toFixed(2)}</strong></div>
        <input type="text" id="table-number" placeholder="Enter your Table Number" required>
        <input type="email" id="gmail-input" placeholder="Enter your Gmail" required>
        <button id="order-btn">Order</button>
    `;

    cartContainer.appendChild(orderSection);

    document.querySelector('#order-btn').onclick = () => {
        let tableNumber = document.querySelector('#table-number').value;
        let gmail = document.querySelector('#gmail-input').value;

        if (!gmail || !tableNumber) {
            alert('Please enter both your Gmail address and Table Number.');
            return;
        }

        // Calculate total price
        let totalPrice = 0;
        cart.forEach(item => {
            let quantity = document.querySelector(`#quantity-${item.id}`).value;
            totalPrice += item.price * quantity;
        });

        let orderData = {
            table_number: tableNumber,
            email: gmail,
            total_price: totalPrice, // Include total price in the order data
            items: cart.map(item => {
                let quantity = document.querySelector(`#quantity-${item.id}`).value;
                let totalPriceForItem = item.price * quantity;
                return {
                    id: item.id,
                    name: item.name,
                    price: totalPriceForItem,
                    quantity: quantity
                };
            })
        };

        fetch('order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            localStorage.setItem('cart', JSON.stringify([]));
            loadFavItems();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error placing your order.');
        });
    };

    updateTotalPrice();
}

// Function to update total price when quantity changes
function updateTotalPrice() {
    let cart = JSON.parse(localStorage.getItem('cart'));
    let totalPrice = 0;

    cart.forEach(item => {
        let quantity = document.getElementById(`quantity-${item.id}`).value || 1;
        totalPrice += item.price * quantity;
    });

    document.querySelector('.total-price-display').innerHTML = `<strong>Total Price: $${totalPrice.toFixed(2)}</strong>`;
}

// Remove item from cart
function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cart'));
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadFavItems();
}

// -----------------------------------------------------------------------------------



// Load cart items on page load
window.onload = loadFavItems;

