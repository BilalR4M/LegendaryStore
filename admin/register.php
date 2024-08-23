<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\Admin;

Auth::requireAdmin();

if (isset($_POST['submit'])) {
    $name = Validate::text($_POST['name'] ?? '', 20);
    $password = Validate::password($_POST['pass'] ?? '');
    $confirm = (string) ($_POST['cpass'] ?? '');

    if ($name === '' || $password === null) {
        Flash::add('check the account details');
    } elseif (Admin::findByName($name) !== null) {
        Flash::add('username already exist');
    } elseif ($password !== $confirm) {
        Flash::add('confirm password not matched');
    } else {
        Admin::create($name, $password);
        Flash::add('new admin registered successfully');
        header('Location: accounts.php');
        exit;
    }
}

$pageTitle = 'register admin';
require dirname(__DIR__) . '/app/views/partials/admin_header.php';
?>

<section class="form-container">
   <form action="" method="post">
      <?= csrf_field() ?>
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="72" class="box">
      <input type="password" name="cpass" required placeholder="confirm your password" maxlength="72" class="box">
      <input type="submit" value="register now" class="btn" name="submit">
   </form>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/admin_footer.php'; ?>
