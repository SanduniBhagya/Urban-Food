<?php session_start(); ?>
<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - UrbanEats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/urbaneats-lightlogo-nobg.png" alt="UrbanEats Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="php/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Menu Header -->
<section class="menu-header py-5 mt-5">
    <div class="container">
        <h1 class="text-center mb-4">Our Menu</h1>

        <!-- Category Filter -->
        <div class="category-filter mb-4 text-center">
            <button class="btn btn-outline-primary active" data-category="all">All</button>
            <button class="btn btn-outline-primary" data-category="burgers">Burgers</button>
            <button class="btn btn-outline-primary" data-category="pizzas">Pizzas</button>
            <button class="btn btn-outline-primary" data-category="drinks">Drinks</button>
            <button class="btn btn-outline-primary" data-category="desserts">Desserts</button>
        </div>
    </div>
</section>

<!-- Menu Items -->
<section class="menu-items py-5">
    <div class="container">
        <div class="row" id="menu-items">
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM MENU_ITEMS ORDER BY CATEGORY, NAME");
                
                while ($row = $stmt->fetch()):
            ?>
            <div class="col-md-4 mb-4 fade-in menu-item-wrapper" data-category="<?= strtolower($row['CATEGORY']) ?>">
                <div class="menu-item">
                    <img src="<?= htmlspecialchars($row['IMAGE_URL']) ?>" alt="<?= htmlspecialchars($row['NAME']) ?>" class="img-fluid">
                    <div class="menu-item-content">
                        <h5><?= htmlspecialchars($row['NAME']) ?></h5>
                        <p><?= htmlspecialchars($row['DESCRIPTION']) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="menu-item-price">LKR&nbsp;<?= number_format($row['PRICE'], 2) ?></span>
                            <button class="btn btn-primary" onclick="addToCart(<?= $row['ID'] ?>)">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
            } catch (PDOException $e) {
                echo "<p class='text-danger'>Error loading menu items: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>UrbanEats</h5>
                <p>Delivering happiness, one meal at a time.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact Us</h5>
                <p><i class="fas fa-phone"></i> (555) 123-4567<br>
                   <i class="fas fa-envelope"></i> info@urbaneats.com</p>
            </div>
        </div>
    </div>
</footer>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    function updateCartCount() {
        const count = cart.reduce((sum, item) => sum + item.quantity, 0);
        $('.cart-count').text(count);
    }

    function addToCart(itemId) {
        const item = cart.find(i => i.id === itemId);
        if (item) {
            item.quantity += 1;
        } else {
            cart.push({ id: itemId, quantity: 1 });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        showToast('Item added to cart!');
    }

    function showToast(message) {
        const toast = $('<div>').addClass('toast').text(message).css({
            position: 'fixed',
            bottom: '20px',
            right: '20px',
            background: '#333',
            color: '#fff',
            padding: '10px 20px',
            borderRadius: '5px',
            zIndex: 9999
        });
        $('body').append(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    $(document).ready(() => {
        updateCartCount();

        $('.category-filter button').click(function () {
            const category = $(this).data('category');
            $('.category-filter button').removeClass('active');
            $(this).addClass('active');

            $('.menu-item-wrapper').each(function () {
                const itemCategory = $(this).data('category');
                $(this).toggle(category === 'all' || category === itemCategory);
            });
        });
    });
</script>
</body>
</html>
