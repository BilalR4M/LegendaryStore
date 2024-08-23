<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\Admin;

Auth::requireAdmin();
$adminId = Auth::adminId();

if (isset($_POST['delete_admin'])) {
    $id = Validate::id($_POST['delete_id'] ?? null);
    if ($id === null) {
        Flash::add('account was not deleted');
    } elseif ($id === $adminId) {
        Flash::add('you cannot delete the account you are using');
    } elseif (Admin::count() < 2) {
        Flash::add('keep at least one admin account');
    } else {
        Admin::delete($id);
        Flash::add('admin account deleted');
    }
    header('Location: accounts.php');
    exit;
}

$accounts = Admin::all();
$pageTitle = 'admin accounts';
require dirname(__DIR__) . '/app/views/partials/admin_header.php';
?>

<section class="accounts">
   <h1 class="heading">admin accounts</h1>
   <div class="box-container">
      <div class="box">
         <p>add new admin</p>
         <a href="register.php" class="option-btn">register admin</a>
      </div>
      <?php if ($accounts === []): ?>
         <p class="empty">no accounts available!</p>
      <?php else: ?>
         <?php foreach ($accounts as $account): ?>
            <div class="box">
               <p> admin id : <span><?= e((string) $account['id']) ?></span> </p>
               <p> admin name : <span><?= e((string) $account['name']) ?></span> </p>
               <div class="flex-btn">
                  <form action="" method="post" class="inline-form" onsubmit="return confirm('delete this account?');">
                     <?= csrf_field() ?>
                     <input type="hidden" name="delete_id" value="<?= e((string) $account['id']) ?>">
                     <button type="submit" name="delete_admin" value="1" class="delete-btn">delete</button>
                  </form>
                  <?php if ((int) $account['id'] === $adminId): ?>
                     <a href="profile.php" class="option-btn">update</a>
                  <?php endif; ?>
               </div>
            </div>
         <?php endforeach; ?>
      <?php endif; ?>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/admin_footer.php'; ?>
