<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\Admin;

if (isset($_POST['submit'])) {
    $name = Validate::text($_POST['name'] ?? '', 20);
    $password = (string) ($_POST['pass'] ?? '');
    $admin = $name === '' ? null : Admin::attempt($name, $password);

    if ($admin === null) {
        Flash::add('incorrect username or password');
    } else {
        Auth::loginAdmin((int) $admin['id']);
        header('Location: dashboard.php');
        exit;
    }
}

$messages = Flash::pull();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
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

<section class="form-container">
   <form action="" method="post">
      <?= csrf_field() ?>
      <h3>login now</h3>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="72" class="box">
      <input type="submit" value="login now" class="btn" name="submit">
   </form>
</section>
</body>
</html>
