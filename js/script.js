let navbar = document.querySelector('.navbar');

document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');
}

let searchForm = document.querySelector('.search-form');

document.querySelector('#search-btn').onclick = () =>{
    searchForm.classList.toggle('active');
    navbar.classList.remove('active');
    cartItem.classList.remove('active');
}

let cartItem = document.querySelector('.cart-items-container');

document.querySelector('#cart-btn').onclick = () =>{
    cartItem.classList.toggle('active');
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
}
// favorite item
let favorite = document.querySelector('.cart-items-container');

document.querySelector('#favorite').onclick = () =>{
    favorite.classList.toggle('active');
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
}//end fav

window.onscroll = () =>{
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');
}
// -------------------------------------------------

// Initialize cart if not present in localStorage
if (!localStorage.getItem('cart')) {
    localStorage.setItem('cart', JSON.stringify([]));
}

// Add to cart function
function addToCart(id, name, price, image) {
    // Retrieve the existing cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart'));

    // Check if the item already exists in the cart
    let existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        alert('This item is already in your cart!');
        return;
    }
    
    // Add new item to the cart
    cart.push({ id, name, price, image });
    alert('Successfully Added!');
    localStorage.setItem('cart', JSON.stringify(cart));

    // Update cart display
    loadFavItems();
}

// Load cart items to display in the cart section
function loadFavItems() {
    let cart = JSON.parse(localStorage.getItem('cart'));
    let cartContainer = document.querySelector('.cart-items-container');
    
    // Clear previous cart items
    cartContainer.innerHTML = '';

    // Iterate over cart items and display them
    cart.forEach(item => {
        let cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <span class="fas fa-times" onclick="removeFromCart('${item.id}')"></span>
            <img src="${item.image}" alt="">
            <div class="content">
                <h3>${item.name}</h3>
                <div class="price">$${item.price.toFixed(2)}</div>
            </div>
        `;
        cartContainer.appendChild(cartItem);
    });
}

// Remove item from cart
function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cart'));
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadFavItems();
}

// Load cart items on page load
window.onload = loadFavItems;

// favorite---------------------------------
// -------------------------------------------------------------------------------------------
