<?php

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Models\Admin;

$pageTitle = $pageTitle ?? 'admin';
$admin = Admin::find(Auth::adminId());
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
   <link rel="stylesheet" href="../public/assets/css/admin_style.css">
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
      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>
      <nav class="navbar">
         <a href="dashboard.php">home</a>
         <a href="products.php">products</a>
         <a href="orders.php">orders</a>
         <a href="accounts.php">admins</a>
         <a href="users.php">users</a>
         <a href="messages.php">messages</a>
      </nav>
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>
      <div class="profile">
         <p><?= e((string) ($admin['name'] ?? 'admin')) ?></p>
         <a href="profile.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="register.php" class="option-btn">register</a>
            <a href="login.php" class="option-btn">login</a>
         </div>
         <form action="logout.php" method="post" onsubmit="return confirm('logout from the website?');">
            <?= csrf_field() ?>
            <button type="submit" class="delete-btn">logout</button>
         </form>
      </div>
   </section>
</header>
