<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\User;

Auth::requireUser();
$user = User::find(Auth::userId());
if ($user === null) {
    Auth::logout();
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $name = Validate::text($_POST['name'] ?? '', 20);
    $email = Validate::email($_POST['email'] ?? '');

    if ($name === '' || $email === null) {
        Flash::add('check the account details');
    } elseif (User::emailTaken($email, (int) $user['id'])) {
        Flash::add('email already exists');
    } else {
        User::updateProfile((int) $user['id'], $name, $email);
        $old = (string) ($_POST['old_pass'] ?? '');
        $new = (string) ($_POST['new_pass'] ?? '');
        $confirm = (string) ($_POST['cpass'] ?? '');

        if ($old === '' && $new === '' && $confirm === '') {
            Flash::add('profile updated');
        } elseif (!password_verify($old, (string) $user['password'])) {
            Flash::add('old password not matched');
        } elseif ($new !== $confirm || Validate::password($new) === null) {
            Flash::add('confirm password not matched');
        } else {
            User::updatePassword((int) $user['id'], $new);
            Flash::add('password updated successfully');
        }
        header('Location: account.php');
        exit;
    }
}

$pageTitle = 'update profile';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="form-container">
   <form action="" method="post">
      <?= csrf_field() ?>
      <h3>update now</h3>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box" value="<?= e((string) $user['name']) ?>">
      <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" value="<?= e((string) $user['email']) ?>">
      <input type="password" name="old_pass" placeholder="enter your old password" maxlength="72" class="box">
      <input type="password" name="new_pass" placeholder="enter your new password" maxlength="72" class="box">
      <input type="password" name="cpass" placeholder="confirm your new password" maxlength="72" class="box">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
