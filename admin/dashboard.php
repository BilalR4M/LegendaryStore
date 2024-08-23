<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

Auth::requireAdmin();
$admin = Admin::find(Auth::adminId());

$pageTitle = 'dashboard';
require dirname(__DIR__) . '/app/views/partials/admin_header.php';
?>

<section class="dashboard">
   <h1 class="heading">dashboard</h1>
   <div class="box-container">
      <div class="box">
         <h3>welcome!</h3>
         <p><?= e((string) ($admin['name'] ?? '')) ?></p>
         <a href="profile.php" class="btn">update profile</a>
      </div>
      <div class="box">
         <h3><span>$</span><?= e((string) Order::sumByStatus('pending')) ?><span>/-</span></h3>
         <p>total pendings</p>
         <a href="orders.php" class="btn">see orders</a>
      </div>
      <div class="box">
         <h3><span>$</span><?= e((string) Order::sumByStatus('completed')) ?><span>/-</span></h3>
         <p>completed orders</p>
         <a href="orders.php" class="btn">see orders</a>
      </div>
      <div class="box">
         <h3><?= e((string) Order::count()) ?></h3>
         <p>orders placed</p>
         <a href="orders.php" class="btn">see orders</a>
      </div>
      <div class="box">
         <h3><?= e((string) Product::count()) ?></h3>
         <p>products added</p>
         <a href="products.php" class="btn">see products</a>
      </div>
      <div class="box">
         <h3><?= e((string) User::count()) ?></h3>
         <p>normal users</p>
         <a href="users.php" class="btn">see users</a>
      </div>
      <div class="box">
         <h3><?= e((string) Admin::count()) ?></h3>
         <p>admin users</p>
         <a href="accounts.php" class="btn">see admins</a>
      </div>
      <div class="box">
         <h3><?= e((string) Message::count()) ?></h3>
         <p>new messages</p>
         <a href="messages.php" class="btn">see messages</a>
      </div>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/admin_footer.php'; ?>
