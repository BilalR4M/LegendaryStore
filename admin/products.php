<?php

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Helpers\Auth;
use App\Helpers\Flash;
use App\Helpers\Upload;
use App\Helpers\Validate;
use App\Models\Product;

Auth::requireAdmin();

if (isset($_POST['delete_product'])) {
    $id = Validate::id($_POST['delete_id'] ?? null);
    $product = $id === null ? null : Product::find($id);
    if ($product !== null) {
        Product::delete($id);
        Upload::remove((string) $product['image_01']);
        Upload::remove((string) $product['image_02']);
        Upload::remove((string) $product['image_03']);
        Flash::add('product deleted');
    }
    header('Location: products.php');
    exit;
}

if (isset($_POST['add_product'])) {
    $name = Validate::text($_POST['name'] ?? '', 100);
    $details = Validate::text($_POST['details'] ?? '', 500);
    $price = Validate::price($_POST['price'] ?? null);
    $category = Validate::category($_POST['category'] ?? '');
    $stored = [];
    $failed = false;

    if ($name === '' || $details === '' || $price === null || $category === null) {
        Flash::add('check the product details');
        $failed = true;
    } elseif (Product::nameExists($name)) {
        Flash::add('product name already exist');
        $failed = true;
    } else {
        foreach (['image_01', 'image_02', 'image_03'] as $field) {
            $file = $_FILES[$field] ?? [];
            if ((int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                Flash::add('three valid images are required');
                $failed = true;
                break;
            }
            $filename = Upload::store($file);
            if ($filename === null) {
                $failed = true;
                break;
            }
            $stored[] = $filename;
        }
    }

    if ($failed) {
        foreach ($stored as $filename) {
            Upload::remove($filename);
        }
    } else {
        Product::create($name, $details, $price, $category, $stored[0], $stored[1], $stored[2]);
        Flash::add('new product added');
        header('Location: products.php');
        exit;
    }
}

$products = Product::all();
$pageTitle = 'products';
require dirname(__DIR__) . '/app/views/partials/admin_header.php';
?>

<section class="add-products">
   <h1 class="heading">add product</h1>
   <form action="" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="flex">
         <div class="inputBox">
            <span>product name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>product price (required)</span>
            <input type="number" min="0" class="box" required max="999999999" placeholder="enter product price" name="price">
         </div>
         <div class="inputBox">
            <span>category (required)</span>
            <select name="category" class="box" required>
               <?php foreach (Validate::CATEGORIES as $category): ?>
                  <option value="<?= e($category) ?>"><?= e($category) ?></option>
               <?php endforeach; ?>
            </select>
         </div>
         <div class="inputBox">
            <span>image 01 (required)</span>
            <input type="file" name="image_01" accept="image/jpeg, image/png, image/webp" class="box" required>
         </div>
         <div class="inputBox">
            <span>image 02 (required)</span>
            <input type="file" name="image_02" accept="image/jpeg, image/png, image/webp" class="box" required>
         </div>
         <div class="inputBox">
            <span>image 03 (required)</span>
            <input type="file" name="image_03" accept="image/jpeg, image/png, image/webp" class="box" required>
         </div>
         <div class="inputBox">
            <span>product details (required)</span>
            <textarea name="details" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>
</section>

<section class="show-products">
   <h1 class="heading">products added</h1>
   <div class="box-container">
   <?php if ($products === []): ?>
      <p class="empty">no products added yet!</p>
   <?php else: ?>
      <?php foreach ($products as $product): ?>
         <div class="box">
            <img src="../public/uploads/<?= e((string) $product['image_01']) ?>" alt="">
            <div class="name"><?= e((string) $product['name']) ?></div>
            <div class="price">$<span><?= e((string) $product['price']) ?></span>/-</div>
            <div class="details"><span><?= e((string) $product['details']) ?></span></div>
            <div class="flex-btn">
               <a href="update_product.php?update=<?= e((string) $product['id']) ?>" class="option-btn">update</a>
               <form action="" method="post" class="inline-form" onsubmit="return confirm('delete this product?');">
                  <?= csrf_field() ?>
                  <input type="hidden" name="delete_id" value="<?= e((string) $product['id']) ?>">
                  <button type="submit" name="delete_product" value="1" class="delete-btn">delete</button>
               </form>
            </div>
         </div>
      <?php endforeach; ?>
   <?php endif; ?>
   </div>
</section>

<?php require dirname(__DIR__) . '/app/views/partials/admin_footer.php'; ?>
