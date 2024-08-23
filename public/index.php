<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Catalog;
use App\Models\Product;

$userId = Auth::userId();
Catalog::handlePost($userId);
$products = Product::latest(6);

$pageTitle = 'home';
$extraHead = '<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<div class="home-bg">
<section class="home">
   <div class="swiper home-slider">
   <div class="swiper-wrapper">
      <div class="swiper-slide slide">
         <div class="image">
            <img src="assets/img/home-1.png" alt="">
         </div>
         <div class="content">
            <span>get your</span>
            <h3>latest games</h3>
            <a href="shop.php" class="btn">order now</a>
         </div>
      </div>
      <div class="swiper-slide slide">
         <div class="image">
            <img src="assets/img/home-2.png" alt="">
         </div>
         <div class="content">
            <span>get your</span>
            <h3>latest movies</h3>
            <a href="shop.php" class="btn">order now</a>
         </div>
      </div>
      <div class="swiper-slide slide">
         <div class="image">
            <img src="assets/img/home-3.png" alt="">
         </div>
         <div class="content">
            <span>get your</span>
            <h3>latest music</h3>
            <a href="shop.php" class="btn">order now</a>
         </div>
      </div>
   </div>
      <div class="swiper-pagination"></div>
   </div>
</section>
</div>

<section class="category">
   <h1 class="heading">categories</h1>
   <div class="swiper category-slider">
   <div class="swiper-wrapper">
   <a href="category.php?category=game" class="swiper-slide slide">
      <img src="assets/img/game.png" alt="">
      <h3>games</h3>
   </a>
   <a href="category.php?category=movie" class="swiper-slide slide">
      <img src="assets/img/movie.png" alt="">
      <h3>movies</h3>
   </a>
   <a href="category.php?category=music" class="swiper-slide slide">
      <img src="assets/img/music.png" alt="">
      <h3>music</h3>
   </a>
   <a href="category.php?category=offer" class="swiper-slide slide">
      <img src="assets/img/offer.png" alt="">
      <h3>offers</h3>
   </a>
   <a href="category.php?category=giftcard" class="swiper-slide slide">
      <img src="assets/img/gift.png" alt="">
      <h3>giftcards</h3>
   </a>
   </div>
   </div>
</section>

<section class="home-products">
   <h1 class="heading">latest products</h1>
   <div class="swiper products-slider">
   <div class="swiper-wrapper">
   <?php if ($products === []): ?>
      <p class="empty">no products added yet!</p>
   <?php else: ?>
      <?php foreach ($products as $product): ?>
         <?php $cardClass = 'swiper-slide slide'; require dirname(__DIR__) . '/app/views/partials/product_card.php'; ?>
      <?php endforeach; ?>
   <?php endif; ?>
   </div>
   <div class="swiper-pagination"></div>
   </div>
</section>

<?php
$pageScripts = <<<'HTML'
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script>
var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: { el: ".swiper-pagination", clickable:true },
});
var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: { el: ".swiper-pagination", clickable:true },
   breakpoints: {
      0: { slidesPerView: 2 },
      650: { slidesPerView: 3 },
      768: { slidesPerView: 4 },
      1024: { slidesPerView: 5 },
   },
});
var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: { el: ".swiper-pagination", clickable:true },
   breakpoints: {
      550: { slidesPerView: 2 },
      768: { slidesPerView: 2 },
      1024: { slidesPerView: 3 },
   },
});
</script>
HTML;
require dirname(__DIR__) . '/app/views/partials/footer.php';
