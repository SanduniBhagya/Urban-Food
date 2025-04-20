document.addEventListener('DOMContentLoaded', function() {
    // Sample product data (in a real app, this would come from an API)
    const products = [
        
            {
                "id": 1,
                "name": "Organic Apples",
                "price": 1000,
                "category": "fruits",
                "image": "images/products/apples.jpg",
                "stock": 50,
                "description": "Fresh organic apples from local farms"
            },
            {
                "id": 2,
                "name": "Carrots",
                "price": 500,
                "category": "vegetables",
                "image": "images/products/carrots.jpg",
                "stock": 30,
                "description": "Crunchy fresh carrots"
            },
            {
                "id": 3,
                "name": "Fresh Cow Milk (1L)",
                "price": 300,
                "category": "dairy",
                "image": "images/products/milk.jpg",
                "stock": 20,
                "description": "Fresh whole milk from local dairy farms"
            },
            {
                    "id": 4,
                    "name": "Pastry",
                    "price": 400,
                    "category": "baked",
                    "image": "images/products/pastry.jpg",
                    "stock": 20,
                    "description": "Just out of oven Pastries"
            },
            {
                "id": 5,
                "name": "Bananas (1kg)",
                "price": 400,
                "category": "fruits",
                "image": "images/products/bananas.jpg",
                "stock": 40,
                "description": "Sweet ripe bananas"
            },
            {
                "id": 6,
                "name": "Broccoli",
                "price": 800,
                "category": "vegetables",
                "image": "images/products/broccoli.jpg",
                "stock": 25,
                "description": "Fresh green broccoli"
            },
            {
                "id": 7,
                "name": "Paneer (250g)",
                "price": 1200,
                "category": "dairy",
                "image": "images/products/paneer.jpg",
                "stock": 18,
                "description": "Fresh homemade paneer"
            },
            {
                "id": 8,
                "name": "Local Curd (Dahi)",
                "price": 350,
                "category": "dairy",
                "image": "images/products/curd.jpg",
                "stock": 25,
                "description": "Traditional Sri Lankan curd"
            },
            {
                "id": 9,
                "name": "Handwoven Sarong",
                "price": 4500,
                "category": "handmade",
                "image": "images/products/sarong.jpg",
                "stock": 8,
                "description": "Traditional Sri Lankan handwoven sarong"
            },
            {
                "id": 10,
                "name": "Clay Pottery (Set of 3)",
                "price": 3500,
                "category": "handmade",
                "image": "images/products/pottery.jpg",
                "stock": 5,
                "description": "Handcrafted Sri Lankan clay pottery"
            },
            {
                "id": 11,
                "name": "Wooden Masks (Hand-carved)",
                "price": 6000,
                "category": "handmade",
                "image": "images/products/woodenmask.jpg",
                "stock": 10,
                "description": "Traditional Sri Lankan wooden masks"
            },
            {
                "id": 12,
                "name": "Ceylon Tea (Handpicked)",
                "price": 1500,
                "category": "handmade",
                "image": "images/products/ceylontea.jpg",
                "stock": 30,
                "description": "Premium Sri Lankan handpicked tea leaves"
            },
            {
                "id": 13,
                "name": "Buffalo Curd & Treacle",
                "price": 600,
                "category": "dairy",
                "image": "images/products/buffalocurds.jpg",
                "stock": 15,
                "description": "Classic Sri Lankan buffalo curd with kithul treacle"
            },
            {
                "id": 14,
                "name": "Handmade Beeralu Lace",
                "price": 5000,
                "category": "handmade",
                "image": "images/products/beeralu.jpg",
                "stock": 7,
                "description": "Traditional Sri Lankan lacework"
            },

            {
                "id": 15,
                "name": "Kiri Bath (Milk Rice)",
                "price": 400,
                "category": "baked",
                "image": "images/products/kiribath.jpg",
                "stock": 20,
                "description": "Traditional Sri Lankan coconut milk rice"
            },
            {
                "id": 16,
                "name": "Roasted Paan",
                "price": 250,
                "category": "baked",
                "image": "images/products/roastedpaan.jpg",
                "stock": 30,
                "description": "Crispy Sri Lankan roasted bread"
            },
            {
                "id": 17,
                "name": "Kavum (Oil Cakes)",
                "price": 600,
                "category": "baked",
                "image": "images/products/kavum.jpg",
                "stock": 15,
                "description": "Traditional Sri Lankan sweet fried cakes"
            },
            {
                "id": 18,
                "name": "Hoppers (Appa)",
                "price": 350,
                "category": "baked",
                "image": "images/products/hoppers.jpg",
                "stock": 25,
                "description": "Bowl-shaped coconut milk pancakes"
            },
            {
                "id": 19,
                "name": "Weli Thalapa (Rice Flour Cake)",
                "price": 450,
                "category": "baked",
                "image": "images/products/welithalapa.jpg",
                "stock": 18,
                "description": "Steamed rice flour cake with coconut"
            },
            {
                "id": 20,
                "name": "Konda Kavum",
                "price": 700,
                "category": "baked",
                "image": "images/products/kondakavum.jpg",
                "stock": 12,
                "description": "Traditional Sri Lankan treacle cakes"
            },
        
            // Handmade Crafts
            {
                "id": 21,
                "name": "Coconut Shell Crafts",
                "price": 1800,
                "category": "handmadecrafts",
                "image": "images/products/coconutcraft.jpg",
                "stock": 12,
                "description": "Handmade decorative items from coconut shells"
            },
            {
                "id": 22,
                "name": "Batik Wall Art",
                "price": 3500,
                "category": "handmadecrafts",
                "image": "images/products/batik.jpg",
                "stock": 5,
                "description": "Traditional Sri Lankan batik fabric art"
            },
            {
                "id": 23,
                "name": "Lacquerware Box",
                "price": 4200,
                "category": "handmadecrafts",
                "image": "images/products/lacquerware.jpg",
                "stock": 8,
                "description": "Handcrafted wooden box with traditional lacquer designs"
            },
            {
                "id": 24,
                "name": "Handwoven Dumbara Mat",
                "price": 5500,
                "category": "handmadecrafts",
                "image": "images/products/dumbara.jpg",
                "stock": 6,
                "description": "Traditional patterned mat made from hemp fibers"
            },
            {
                "id": 25,
                "name": "Brass Elephant Statue",
                "price": 6800,
                "category": "handmadecrafts",
                "image": "images/products/brasselephant.jpg",
                "stock": 4,
                "description": "Handcrafted brass elephant with intricate designs"
            },
            {
                "id": 26,
                "name": "Handmade Jewelry Set",
                "price": 3800,
                "category": "handmadecrafts",
                "image": "images/products/jewelry.jpg",
                "stock": 9,
                "description": "Silver and bead jewelry with traditional motifs"
            }
        ];
    

    // DOM Elements
    const productGrid = document.querySelector('.product-grid');
    const categoryFilter = document.getElementById('category-filter');
    const searchBox = document.getElementById('search-box');

    // Initialize the page
    displayProducts(products);
    setupEventListeners();

    function displayProducts(productsToDisplay) {
        productGrid.innerHTML = ''; // Clear existing products

        if (productsToDisplay.length === 0) {
            productGrid.innerHTML = '<p class="no-products">No products found matching your criteria.</p>';
            return;
        }

        productsToDisplay.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';
            productCard.innerHTML = `
                <div class="product-image">
                    <img src="${product.image}" alt="${product.name}">
                </div>
                <div class="product-info">
                    <h3 class="product-title">${product.name}</h3>
                    <p class="product-description">${product.description}</p>
                    <div class="product-meta">
                        <span class="product-price">LKR ${product.price.toFixed(2)}</span>
                        <span class="product-stock">${product.stock} in stock</span>
                    </div>
                    <div class="product-actions">
                        <button class="btn btn-primary add-to-cart" data-id="${product.id}">
                            Add to Cart
                        </button>
                        <button class="btn btn-secondary view-details" data-id="${product.id}">
                            Details
                        </button>
                    </div>
                </div>
            `;
            productGrid.appendChild(productCard);
        });
    }

    function setupEventListeners() {
        // Category filter
        categoryFilter.addEventListener('change', filterProducts);
        
        // Search box
        searchBox.addEventListener('input', filterProducts);
        
        // Add to cart buttons (using event delegation)
        productGrid.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-to-cart')) {
                const productId = parseInt(e.target.getAttribute('data-id'));
                addToCart(productId);
            }
            
            if (e.target.classList.contains('view-details')) {
                const productId = parseInt(e.target.getAttribute('data-id'));
                viewProductDetails(productId);
            }
        });
    }

    function filterProducts() {
        const selectedCategory = categoryFilter.value;
        const searchTerm = searchBox.value.toLowerCase();
        
        let filteredProducts = products;
        
        // Filter by category
        if (selectedCategory !== 'all') {
            filteredProducts = filteredProducts.filter(
                product => product.category === selectedCategory
            );
        }
        
        // Filter by search term
        if (searchTerm) {
            filteredProducts = filteredProducts.filter(
                product => product.name.toLowerCase().includes(searchTerm) ||
                    product.description.toLowerCase().includes(searchTerm)
            );
        }
        
        displayProducts(filteredProducts);
    }

    function addToCart(productId) {
        const product = products.find(p => p.id === productId);
        if (!product) return;
        
        // Get existing cart from localStorage or create new one
        let cart = JSON.parse(localStorage.getItem('urbanfood_cart')) || [];
        
        // Check if product already in cart
        const existingItem = cart.find(item => item.id === productId);
        
        if (existingItem) {
            // Increase quantity if already in cart
            if (existingItem.quantity < product.stock) {
                existingItem.quantity += 1;
            } else {
                alert(`Only ${product.stock} ${product.name} available in stock!`);
                return;
            }
        } else {
            // Add new item to cart
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: 1
            });
        }
        
        // Save back to localStorage
        localStorage.setItem('urbanfood_cart', JSON.stringify(cart));
        
        // Show feedback
        alert(`${product.name} added to cart!`);
        
        // You might want to update a cart counter in the header here
        updateCartCounter();
    }

    function viewProductDetails(productId) {
        // In a real app, this would navigate to a product details page
        const product = products.find(p => p.id === productId);
        if (product) {
            alert(`Product Details:\n\nName: ${product.name}\nPrice: $${product.price.toFixed(2)}\nDescription: ${product.description}\nStock: ${product.stock}`);
        }
    }

    function updateCartCounter() {
        // Update cart counter in header if it exists
        const cartCounter = document.getElementById('cart-counter');
        if (cartCounter) {
            const cart = JSON.parse(localStorage.getItem('urbanfood_cart')) || [];
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCounter.textContent = totalItems;
        }
    }

    // Initialize cart counter
    updateCartCounter();
});