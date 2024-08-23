<?php

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Models\Cart;
use App\Models\User;
use App\Models\Wishlist;

$pageTitle = $pageTitle ?? 'LegendaryStore';
$userId = Auth::userId();
$profile = $userId > 0 ? User::find($userId) : null;
$wishlistCount = Wishlist::countFor($userId);
$cartCount = Cart::countFor($userId);
$messages = Flash::pull();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?= e($pageTitle) ?></title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
   <?= $extraHead ?? '' ?>
</head>
<body>
<?php foreach ($messages as $message): ?>
   <div class="message">
      <span><?= e($message) ?></span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
   </div>
<?php endforeach; ?>

<header class="header">
   <section class="flex">
      <a href="index.php" class="logo">LEGENDARYSTORE</a>
      <nav class="navbar">
         <a href="index.php">home</a>
         <a href="about.php">about</a>
         <a href="orders.php">orders</a>
         <a href="shop.php">products</a>
         <a href="contact.php">contact</a>
      </nav>
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= e((string) $wishlistCount) ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= e((string) $cartCount) ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>
      <div class="profile">
         <?php if ($profile): ?>
            <p><?= e((string) $profile['name']) ?></p>
            <a href="account.php" class="btn">update profile</a>
            <div class="flex-btn">
               <a href="register.php" class="option-btn">register</a>
               <a href="login.php" class="option-btn">login</a>
            </div>
            <form action="logout.php" method="post" onsubmit="return confirm('logout from the website?');">
               <?= csrf_field() ?>
               <button type="submit" class="delete-btn">logout</button>
            </form>
         <?php else: ?>
            <p>please login or register first!</p>
            <div class="flex-btn">
               <a href="register.php" class="option-btn">register</a>
               <a href="login.php" class="option-btn">login</a>
            </div>
         <?php endif; ?>
      </div>
   </section>
</header>
