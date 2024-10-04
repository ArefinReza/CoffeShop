// Initialize cart and favorites in localStorage if they don't exist
if (!localStorage.getItem('cart')) {
    localStorage.setItem('cart', JSON.stringify([]));
}
if (!localStorage.getItem('favorites')) {
    localStorage.setItem('favorites', JSON.stringify([]));
}

// Add to cart function
function addToCart(id, name, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart'));

    // Check if the item already exists in the cart
    let existingItemInCart = cart.find(item => item.id === id);
    if (existingItemInCart) {
        alert('This item is already in your cart!');
        return;
    }
    
    // Add new item to the cart
    cart.push({ id, name, price, image });
    alert('Item successfully added to cart!');
    localStorage.setItem('cart', JSON.stringify(cart));

    // Update cart display
    loadCartItems();
}

// Add to favorite function
let favoriteItems = [];

function addToFavorites(id, name, price, imgSrc) {
    // Check if the item is already in the favorites
    const itemExists = favoriteItems.find(item => item.id === id);
    if (!itemExists) {
        // Add new item to favorites list
        favoriteItems.push({ id, name, price, imgSrc });

        // Update the favorites list in the DOM
        updateFavoriteItemsContainer();
    } else {
        alert('This item is already in your favorites list!');
    }
}

function updateFavoriteItemsContainer() {
    const favoriteItemsContainer = document.querySelector('.favorite-items-container');
    
    // Clear the container before adding new items
    favoriteItemsContainer.innerHTML = '';

    favoriteItems.forEach(item => {
        const favoriteItemHTML = `
            <div class="favorite-item">
                <img src="${item.imgSrc}" alt="${item.name}">
                <h3>${item.name}</h3>
                <div class="price">$${item.price}</div>
            </div>
        `;
        favoriteItemsContainer.innerHTML += favoriteItemHTML;
    });
}

// Load cart items to display in the cart section
function loadCartItems() {
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

// Load favorite items to display in the favorite section
function loadFavoriteItems() {
    let favorites = JSON.parse(localStorage.getItem('favorites'));
    let favoriteContainer = document.querySelector('.favorite-items-container');
    
    // Clear previous favorite items
    favoriteContainer.innerHTML = '';

    // Iterate over favorite items and display them
    favorites.forEach(item => {
        let favoriteItem = document.createElement('div');
        favoriteItem.classList.add('favorite-item');
        favoriteItem.innerHTML = `
            <span class="fas fa-times" onclick="removeFromFavorites('${item.id}')"></span>
            <img src="${item.image}" alt="">
            <div class="content">
                <h3>${item.name}</h3>
                <div class="price">$${item.price.toFixed(2)}</div>
            </div>
        `;
        favoriteContainer.appendChild(favoriteItem);
    });
}

// Remove item from cart
function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cart'));
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCartItems();
}

// Remove item from favorites
function removeFromFavorites(id) {
    let favorites = JSON.parse(localStorage.getItem('favorites'));
    favorites = favorites.filter(item => item.id !== id);
    localStorage.setItem('favorites', JSON.stringify(favorites));
    loadFavoriteItems();
}

// Load cart and favorite items on page load
window.onload = function() {
    loadCartItems();
    loadFavoriteItems();
};
