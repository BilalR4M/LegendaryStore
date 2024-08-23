<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\User;

if (isset($_POST['submit'])) {
    $name = Validate::text($_POST['name'] ?? '', 20);
    $email = Validate::email($_POST['email'] ?? '');
    $password = Validate::password($_POST['pass'] ?? '');
    $confirm = (string) ($_POST['cpass'] ?? '');

    if ($name === '' || $email === null || $password === null) {
        Flash::add('check the account details');
    } elseif (User::emailTaken($email)) {
        Flash::add('email already exists');
    } elseif ($password !== $confirm) {
        Flash::add('confirm password not matched');
    } else {
        User::create($name, $email, $password);
        Flash::add('registered successfully, login now please');
        header('Location: login.php');
        exit;
    }
}

$pageTitle = 'register';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="form-container">
   <form action="" method="post">
      <?= csrf_field() ?>
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box">
      <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="72" class="box">
      <input type="password" name="cpass" required placeholder="confirm your password" maxlength="72" class="box">
      <input type="submit" value="register now" class="btn" name="submit">
      <p>already have an account?</p>
      <a href="login.php" class="option-btn">login now</a>
   </form>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
