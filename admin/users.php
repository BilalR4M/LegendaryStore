<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\User;

Auth::requireAdmin();

if (isset($_POST['delete_user'])) {
    $id = Validate::id($_POST['delete_id'] ?? null);
    if ($id !== null) {
        User::delete($id);
        Flash::add('user account deleted');
    }
    header('Location: users.php');
    exit;
}

$accounts = User::all();
$pageTitle = 'users accounts';
require dirname(__DIR__) . '/app/views/partials/admin_header.php';
?>

<section class="accounts">
   <h1 class="heading">user accounts</h1>
   <div class="box-container">
   <?php if ($accounts === []): ?>
      <p class="empty">no accounts available!</p>
   <?php else: ?>
      <?php foreach ($accounts as $account): ?>
         <div class="box">
            <p> user id : <span><?= e((string) $account['id']) ?></span> </p>
            <p> username : <span><?= e((string) $account['name']) ?></span> </p>
            <p> email : <span><?= e((string) $account['email']) ?></span> </p>
            <form action="" method="post" onsubmit="return confirm('delete this account? the user related information will also be deleted');">
               <?= csrf_field() ?>
               <input type="hidden" name="delete_id" value="<?= e((string) $account['id']) ?>">
               <button type="submit" name="delete_user" value="1" class="delete-btn">delete</button>
            </form>
         </div>
      <?php endforeach; ?>
   <?php endif; ?>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/admin_footer.php'; ?>
