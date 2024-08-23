<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\Admin;

Auth::requireAdmin();
$admin = Admin::find(Auth::adminId());
if ($admin === null) {
    Auth::logout();
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $name = Validate::text($_POST['name'] ?? '', 20);
    $existing = $name === '' ? null : Admin::findByName($name);

    if ($name === '') {
        Flash::add('check the account details');
    } elseif ($existing !== null && (int) $existing['id'] !== (int) $admin['id']) {
        Flash::add('username already exist');
    } else {
        Admin::updateName((int) $admin['id'], $name);
        $old = (string) ($_POST['old_pass'] ?? '');
        $new = (string) ($_POST['new_pass'] ?? '');
        $confirm = (string) ($_POST['confirm_pass'] ?? '');

        if ($old === '' && $new === '' && $confirm === '') {
            Flash::add('profile updated');
        } elseif (!password_verify($old, (string) $admin['password'])) {
            Flash::add('old password not matched');
        } elseif ($new !== $confirm || Validate::password($new) === null) {
            Flash::add('confirm password not matched');
        } else {
            Admin::updatePassword((int) $admin['id'], $new);
            Flash::add('password updated successfully');
        }
        header('Location: profile.php');
        exit;
    }
}

$pageTitle = 'update profile';
require dirname(__DIR__) . '/app/views/partials/admin_header.php';
?>

<section class="form-container">
   <form action="" method="post">
      <?= csrf_field() ?>
      <h3>update profile</h3>
      <input type="text" name="name" value="<?= e((string) $admin['name']) ?>" required placeholder="enter your username" maxlength="20" class="box">
      <input type="password" name="old_pass" placeholder="enter old password" maxlength="72" class="box">
      <input type="password" name="new_pass" placeholder="enter new password" maxlength="72" class="box">
      <input type="password" name="confirm_pass" placeholder="confirm new password" maxlength="72" class="box">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/admin_footer.php'; ?>
