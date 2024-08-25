<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['id_admin'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['pname'];
   $price = $_POST['price'];
   $category = $_POST['category'];

   $update_product = $conn->prepare("UPDATE products SET id_catergory = ?, product_name = ?, product_price = ? WHERE id_product = ?");
   $update_product->execute([$category, $name, $price, $pid]);

   $message[] = 'product updated!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   if(!empty($image)){
      if($image_size > 20000000){
         $message[] = 'Images size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE products SET product_image = ? WHERE id_product = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/'.$old_image);
         $message[] = 'Image updated!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>
   <link rel="icon" type="image/x-icon" href="../images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link href="../css/admin_style.css" rel="stylesheet">
</head>
<body>

<?php include '../components/admin_header.php' ?>
<section class="update-product">
   <h1 class="heading">Update product</h1>
   <?php
      $update_id = $_GET['update'];
      $show_products = $conn->prepare("SELECT * FROM products JOIN catergory ON products.id_catergory = catergory.id_catergory WHERE id_product = ?");
      $show_products->execute([$update_id]);
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <form method="POST" enctype="multipart/form-data">
      <input type="hidden" id="pid" name="pid" value="<?= $fetch_products['id_product']; ?>">
      <input type="hidden" id="old_image" name="old_image" value="<?= $fetch_products['product_image']; ?>">
      <img src="../uploaded_img/<?= $fetch_products['product_image']; ?>" alt="">
      <span>update name</span>
      <input type="text" required placeholder="enter product name" id="pname" name="pname" maxlength="100" class="box" value="<?= $fetch_products['product_name']; ?>">
      <span>update price</span>
      <input type="number" min="1000" max="9999999999" required placeholder="enter product price" id="price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['product_price']; ?>">
      <span>update category</span>
      <select name="category" class="box" required>
         <option value="<?= $fetch_products['id_catergory'];?>"> <?= $fetch_products['category_name'];?></option>
         <?php
            $category_data = $conn->prepare("SELECT * FROM catergory");
            $category_data->execute();
            while( $fetch_cat_data = $category_data->fetch(PDO::FETCH_ASSOC)):;
         ?>
            
            <option value="<?= $fetch_cat_data['id_catergory'];?>">
                  <?= $fetch_cat_data['category_name'];?>
            </option>
         <?php
            endwhile;
         ?>
      </select>
      <span>update image</span>
      <input type="file" id="image" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="products.php" class="option-btn">Go back</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>