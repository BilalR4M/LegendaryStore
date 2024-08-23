<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Models\Order;

$userId = Auth::userId();
$orders = $userId > 0 ? Order::forUser($userId) : [];

$pageTitle = 'orders';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="orders">
   <h1 class="heading">placed orders</h1>
   <div class="box-container">
   <?php if ($userId < 1): ?>
      <p class="empty">please login to see your orders</p>
   <?php elseif ($orders === []): ?>
      <p class="empty">no orders placed yet!</p>
   <?php else: ?>
      <?php foreach ($orders as $order): ?>
         <?php $statusColor = $order['payment_status'] === 'pending' ? 'red' : 'green'; ?>
         <div class="box">
            <p>placed on : <span><?= e((string) $order['placed_on']) ?></span></p>
            <p>name : <span><?= e((string) $order['name']) ?></span></p>
            <p>email : <span><?= e((string) $order['email']) ?></span></p>
            <p>number : <span><?= e((string) $order['number']) ?></span></p>
            <p>address : <span><?= e((string) $order['address']) ?></span></p>
            <p>payment method : <span><?= e((string) $order['method']) ?></span></p>
            <p>your orders : <span><?= e(Order::itemsLabel((int) $order['id'])) ?></span></p>
            <p>total price : <span>$<?= e((string) $order['total_price']) ?>/-</span></p>
            <p> payment status : <span style="color:<?= e($statusColor) ?>"><?= e((string) $order['payment_status']) ?></span> </p>
         </div>
      <?php endforeach; ?>
   <?php endif; ?>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
