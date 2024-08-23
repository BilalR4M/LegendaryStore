<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\User;

if (isset($_POST['submit'])) {
    $email = Validate::email($_POST['email'] ?? '');
    $password = (string) ($_POST['pass'] ?? '');
    $user = ($email === null) ? null : User::attempt($email, $password);

    if ($user === null) {
        Flash::add('incorrect username or password');
    } else {
        Auth::loginUser((int) $user['id']);
        header('Location: index.php');
        exit;
    }
}

$pageTitle = 'login';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="form-container">
   <form action="" method="post">
      <?= csrf_field() ?>
      <h3>login now</h3>
      <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="72" class="box">
      <input type="submit" value="login now" class="btn" name="submit">
      <p>don't have an account?</p>
      <a href="register.php" class="option-btn">register now</a>
   </form>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
