<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html?error=login_required");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UrbanEats - Checkout</title>
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
                <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php">Cart <span class="cart-count">0</span></a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Checkout Section -->
<div class="checkout-page py-5 mt-5">
    <div class="container">
        <h1 class="text-center mb-5">Checkout</h1>

        <div class="row">
            <div class="col-lg-8">
                <!-- Delivery Information -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Delivery Information</h3>
                        <form id="checkoutForm">
                            <div class="mb-3">
                                <label for="address1" class="form-label">Address Line 1</label>
                                <input type="text" class="form-control" id="address1" required>
                            </div>
                            <div class="mb-3">
                                <label for="address2" class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" class="form-control" id="address2">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="province" class="form-label">Province</label>
                                    <select class="form-select" id="province" required>
                                        <option value="" selected disabled>Select</option>
                                        <option value="Central">Central</option>
                                        <option value="Eastern">Eastern</option>
                                        <option value="Northern">Northern</option>
                                        <option value="North Central">North Central</option>
                                        <option value="North Western">North Western</option>
                                        <option value="Sabaragamuwa">Sabaragamuwa</option>
                                        <option value="Southern">Southern</option>
                                        <option value="Uva">Uva</option>
                                        <option value="Western">Western</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="zip" class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control" id="zip" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+94</span>
                                        <input type="tel" class="form-control" id="contact" placeholder="7XXXXXXXX" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Payment Method</h3>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="cod" checked>
                            <label class="form-check-label" for="cod">Cash on Delivery</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="card" disabled>
                            <label class="form-check-label" for="card">Credit/Debit Card (Coming Soon)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card order-summary">
                    <div class="card-body">
                        <h4 class="card-title">Order Summary</h4>
                        <div id="checkout-items"></div>
                        <hr>
                        <div class="summary-item d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="subtotal">$0.00</span>
                        </div>
                        <div class="summary-item d-flex justify-content-between mb-2">
                            <span>Delivery Fee:</span>
                            <span id="delivery-fee">$2.99</span>
                        </div>
                        <div class="summary-item d-flex justify-content-between mb-3">
                            <span>Tax (10%):</span>
                            <span id="tax">$0.00</span>
                        </div>
                        <hr>
                        <div class="summary-item d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong id="total">$0.00</strong>
                        </div>
                        <button class="btn btn-primary w-100" id="place-order-btn">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4"><h5>UrbanEats</h5><p>Delivering happiness to your doorstep</p></div>
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
                <p>Email: info@urbaneats.com</p>
                <p>Phone: (555) 123-4567</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
