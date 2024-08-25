<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['id_admin'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $pname = $_POST['pname'];
   $price = $_POST['price'];
   $category = $_POST['category'];
   
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$_FILES['image']['name'];

   $select_products = $conn->prepare("SELECT * FROM products WHERE product_name = ?");
   $select_products->execute([$pname]);

   if($select_products->rowCount() > 0){
      $message[] = 'Product name already exists!';
   }else{
      if($image_size > 20000000){
         $message[] = 'Image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);
         $insert_product = $conn->prepare("INSERT INTO products( `id_catergory`, `product_name`, `product_price`, `product_image`) VALUES(?,?,?,?);");
         $insert_product->execute([ $category, $pname, $price, $image]);
         $message[] = 'New product added!';
         header('location:products.php');
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
   <title>Add Products</title>
   <link rel="icon" type="image/x-icon" href="../images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link href="../css/admin_style.css" rel="stylesheet">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="add-products">
   <form method="POST" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" required placeholder="enter product name" id="pname" name="pname" maxlength="100" class="box">
      <input type="number" min="1000" max="9999999999" required placeholder="enter product price" id="price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <select name="category" class="box" required>
         <option selected class="text-center">Choose category</option>
      <?php
         $category_data = $conn->prepare("SELECT * FROM catergory");
         $category_data->execute();
         while($fetch_cat_data = $category_data->fetch(PDO::FETCH_ASSOC)):;
      ?>
         <option value="<?= $fetch_cat_data['id_catergory'];?>">
               <?= $fetch_cat_data['category_name'];?>
         </option>
        
      <?php
         endwhile;
      ?>
      </select>
      <input type="file" id="image" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>