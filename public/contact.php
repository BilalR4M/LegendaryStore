<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Validate;
use App\Models\Message;

if (isset($_POST['send'])) {
    $name = Validate::text($_POST['name'] ?? '', 20);
    $email = Validate::email($_POST['email'] ?? '', 100);
    $number = Validate::phone($_POST['number'] ?? '', 12);
    $body = Validate::text($_POST['msg'] ?? '', 500);
    $userId = Auth::userId();

    if ($name === '' || $email === null || $number === null || $body === '') {
        Flash::add('check the message details');
    } elseif (Message::exists($name, $email, $number, $body)) {
        Flash::add('already sent message');
    } else {
        Message::create($userId > 0 ? $userId : null, $name, $email, $number, $body);
        Flash::add('sent message successfully');
    }
}

$pageTitle = 'contact';
require dirname(__DIR__) . '/app/views/partials/header.php';
?>

<section class="contact">
   <form action="" method="post">
      <?= csrf_field() ?>
      <h3>get in touch</h3>
      <input type="text" name="name" placeholder="enter your name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
      <input type="text" name="number" placeholder="enter your number" required maxlength="12" class="box">
      <textarea name="msg" class="box" placeholder="enter your message" cols="30" rows="10" maxlength="500" required></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/footer.php'; ?>
