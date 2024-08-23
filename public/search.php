<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Catalog;
use App\Helpers\Validate;
use App\Models\Product;

Catalog::handlePost(Auth::userId());

$products = [];
$searched = false;
if (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
    $searched = true;
    $term = Validate::text($_POST['search_box'] ?? '', 100);
    $products = $term === '' ? [] : Product::search($term);
}

$pageTitle = 'search page';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="search-form">
   <form action="" method="post">
      <?= csrf_field() ?>
      <input type="text" name="search_box" placeholder="search here..." maxlength="100" class="box" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>
</section>

<section class="products" style="padding-top: 0; min-height:100vh;">
   <div class="box-container">
   <?php if ($searched && $products === []): ?>
      <p class="empty">no products found!</p>
   <?php endif; ?>
   <?php foreach ($products as $product): ?>
      <?php require dirname(__DIR__) . '/app/views/partials/product_card.php'; ?>
   <?php endforeach; ?>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
