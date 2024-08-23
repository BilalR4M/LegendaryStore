<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Upload;
use App\Helpers\Validate;
use App\Models\Product;

Auth::requireAdmin();

$id = Validate::id($_GET['update'] ?? $_POST['pid'] ?? null);
$product = $id === null ? null : Product::find($id);

if ($product !== null && isset($_POST['update'])) {
    $name = Validate::text($_POST['name'] ?? '', 100);
    $details = Validate::text($_POST['details'] ?? '', 500);
    $price = Validate::price($_POST['price'] ?? null);
    $category = Validate::category($_POST['category'] ?? '');

    if ($name === '' || $details === '' || $price === null || $category === null) {
        Flash::add('check the product details');
    } elseif (Product::nameExists($name, (int) $product['id'])) {
        Flash::add('product name already exist');
    } else {
        Product::update((int) $product['id'], $name, $details, $price, $category);
        foreach (['image_01', 'image_02', 'image_03'] as $slot) {
            $file = $_FILES[$slot] ?? [];
            if ((int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            $filename = Upload::store($file);
            if ($filename === null) {
                continue;
            }
            $previous = (string) $product[$slot];
            Product::updateImage((int) $product['id'], $slot, $filename);
            Upload::remove($previous);
            $product[$slot] = $filename;
        }
        Flash::add('product updated successfully');
        header('Location: update_product.php?update=' . (int) $product['id']);
        exit;
    }
}

if ($id !== null) {
    $product = Product::find($id);
}

$pageTitle = 'update product';
require dirname(__DIR__) . '/app/views/partials/admin_header.php';
?>

<section class="update-product">
   <h1 class="heading">update product</h1>
   <?php if ($product === null): ?>
      <p class="empty">no product found!</p>
   <?php else: ?>
   <form action="" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="pid" value="<?= e((string) $product['id']) ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="../public/uploads/<?= e((string) $product['image_01']) ?>" alt="">
         </div>
         <div class="sub-image">
            <img src="../public/uploads/<?= e((string) $product['image_01']) ?>" alt="">
            <img src="../public/uploads/<?= e((string) $product['image_02']) ?>" alt="">
            <img src="../public/uploads/<?= e((string) $product['image_03']) ?>" alt="">
         </div>
      </div>
      <span>update name</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= e((string) $product['name']) ?>">
      <span>update price</span>
      <input type="number" name="price" required class="box" min="0" max="999999999" placeholder="enter product price" value="<?= e((string) $product['price']) ?>">
      <span>update category</span>
      <select name="category" class="box" required>
         <?php foreach (Validate::CATEGORIES as $category): ?>
            <option value="<?= e($category) ?>" <?= $product['category'] === $category ? 'selected' : '' ?>><?= e($category) ?></option>
         <?php endforeach; ?>
      </select>
      <span>update details</span>
      <textarea name="details" class="box" required maxlength="500" cols="30" rows="10"><?= e((string) $product['details']) ?></textarea>
      <span>update image 01</span>
      <input type="file" name="image_01" accept="image/jpeg, image/png, image/webp" class="box">
      <span>update image 02</span>
      <input type="file" name="image_02" accept="image/jpeg, image/png, image/webp" class="box">
      <span>update image 03</span>
      <input type="file" name="image_03" accept="image/jpeg, image/png, image/webp" class="box">
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="update">
         <a href="products.php" class="option-btn">go back</a>
      </div>
   </form>
   <?php endif; ?>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/admin_footer.php'; ?>
