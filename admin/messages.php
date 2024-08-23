<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\Message;

Auth::requireAdmin();

if (isset($_POST['delete_message'])) {
    $id = Validate::id($_POST['delete_id'] ?? null);
    if ($id !== null) {
        Message::delete($id);
        Flash::add('message deleted');
    }
    header('Location: messages.php');
    exit;
}

$messagesList = Message::all();
$pageTitle = 'messages';
require dirname(__DIR__) . '/app/views/partials/admin_header.php';
?>

<section class="contacts">
   <h1 class="heading">messages</h1>
   <div class="box-container">
   <?php if ($messagesList === []): ?>
      <p class="empty">you have no messages</p>
   <?php else: ?>
      <?php foreach ($messagesList as $entry): ?>
         <div class="box">
            <p> user id : <span><?= e((string) ($entry['user_id'] ?? 'guest')) ?></span></p>
            <p> name : <span><?= e((string) $entry['name']) ?></span></p>
            <p> email : <span><?= e((string) $entry['email']) ?></span></p>
            <p> number : <span><?= e((string) $entry['number']) ?></span></p>
            <p> message : <span><?= e((string) $entry['message']) ?></span></p>
            <form action="" method="post" onsubmit="return confirm('delete this message?');">
               <?= csrf_field() ?>
               <input type="hidden" name="delete_id" value="<?= e((string) $entry['id']) ?>">
               <button type="submit" name="delete_message" value="1" class="delete-btn">delete</button>
            </form>
         </div>
      <?php endforeach; ?>
   <?php endif; ?>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/admin_footer.php'; ?>
