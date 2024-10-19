
const scrollContainer = document.querySelector('.scrolling-box-container');
    
function autoScroll() {
    scrollContainer.scrollBy(1, 0); 


    if (scrollContainer.scrollLeft >= scrollContainer.scrollWidth - scrollContainer.clientWidth) {
        scrollContainer.scrollLeft = 0;
    }
}

setInterval(autoScroll, 20);

document.getElementById('seeMoreBtn').addEventListener('click', function () {

const hiddenProducts = document.querySelectorAll('.hidden-product');


hiddenProducts.forEach(function (product) {
    product.classList.remove('hidden-product');
});

document.getElementById('seeMoreBtn').style.display = 'none';
});






document.getElementById('search-box').addEventListener('input', function () {
var searchTerm = document.getElementById('search-box').value.toLowerCase().trim();

// Get all product boxes
var products = document.querySelectorAll('.box-container .box');

// Get all other components except the search box and product list
var otherComponents = document.querySelectorAll('.blur-on-search');

// If the search term is empty, show all products and remove blur
if (searchTerm === '') {
    resetPage(products, otherComponents);
} else {
    let hasMatch = false;

    // If there is a search term, filter products dynamically
    products.forEach(function (product) {
        var productName = product.querySelector('h3').innerText.toLowerCase();

        // Show the product if it matches the search term, otherwise hide it
        if (productName.includes(searchTerm)) {
            product.style.display = 'block'; // Show matching product
            product.classList.add('fullscreen-product'); // Add full-screen effect
            hasMatch = true;
        } else {
            product.style.display = 'none'; // Hide non-matching product
        }
    });

    // If matching products are found, blur other components
    if (hasMatch) {
        otherComponents.forEach(function (component) {
            component.classList.add('blur'); // Blur other components
        });
    } else {
        resetPage(products, otherComponents);
    }
}
});

// Function to reset the page when the search is cleared or nothing matches
function resetPage(products, otherComponents) {
products.forEach(function (product) {
    product.style.display = 'block'; // Show all products
    product.classList.remove('fullscreen-product'); // Remove full-screen effect
});

otherComponents.forEach(function (component) {
    component.classList.remove('blur'); // Remove blur from other components
});
}
