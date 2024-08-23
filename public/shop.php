<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Catalog;
use App\Models\Product;

Catalog::handlePost(Auth::userId());
$products = Product::all();

$pageTitle = 'shop';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="products">
   <h1 class="heading">latest products</h1>
   <div class="box-container">
   <?php if ($products === []): ?>
      <p class="empty">no products found!</p>
   <?php else: ?>
      <?php foreach ($products as $product): ?>
         <?php require dirname(__DIR__) . '/app/views/partials/product_card.php'; ?>
      <?php endforeach; ?>
   <?php endif; ?>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
