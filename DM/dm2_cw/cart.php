<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html?error=login_required");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cart - UrbanEats</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="css/style.css" />
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
        <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="cart.php">
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

<!-- Cart Section -->
<section class="cart-section py-5 mt-5">
  <div class="container">
    <h1 class="text-center mb-4">Your Cart</h1>

    <div class="row">
      <div class="col-lg-8">
        <div class="cart-items" id="cart-items">
          <!-- Cart items will be loaded via JavaScript -->
        </div>
      </div>
      <div class="col-lg-4">
        <div class="cart-summary card">
          <div class="card-body">
            <h5 class="card-title">Order Summary</h5>
            <div class="summary-item d-flex justify-content-between">
              <span>Subtotal:</span>
              <span id="subtotal">$0.00</span>
            </div>
            <div class="summary-item d-flex justify-content-between">
              <span>Delivery Fee:</span>
              <span id="delivery-fee">$5.00</span>
            </div>
            <div class="summary-item d-flex justify-content-between">
              <span>Tax:</span>
              <span id="tax">$0.00</span>
            </div>
            <hr />
            <div class="summary-item d-flex justify-content-between">
              <strong>Total:</strong>
              <strong id="total">$0.00</strong>
            </div>
            <a href="checkout.php" class="btn btn-primary w-100 mt-3" id="checkout-btn">
              Proceed to Checkout
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-light py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-4"><h5>UrbanEats</h5><p>Delivering happiness, one meal at a time.</p></div>
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
        <p><i class="fas fa-phone"></i> (555) 123-4567</p>
        <p><i class="fas fa-envelope"></i> info@urbaneats.com</p>
      </div>
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/cart.js"></script>

</body>
</html>
