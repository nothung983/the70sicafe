<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['id_admin'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};


if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM products WHERE id_product = ?");
   $delete_product_image->execute([$delete_id]);   
   $delete_cart = $conn->prepare("DELETE FROM cart WHERE id_product = ?");
   $delete_cart->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['product_image']);
   $delete_product = $conn->prepare("DELETE FROM products WHERE id_product = ?");
   $delete_product->execute([$delete_id]);
   header('location:products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>
   <link rel="icon" type="image/x-icon" href="../images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link href="../css/admin_style.css" rel="stylesheet">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="show-products" style="padding-top: 10px;">
   <div class="box-container">
      <div class="box">   
         <img src="../images/GIF/frappe.gif" alt="products">
         <p class="add_new">products added by you</p>
         <a href="add_products.php" class="btn">Add new product</a>
      </div> 
      <?php
         $show_products = $conn->prepare("SELECT * FROM products JOIN catergory ON products.id_catergory = catergory.id_catergory ");
         $show_products->execute();
         if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">   
        
         <img src="../uploaded_img/<?= $fetch_products['product_image']; ?>" alt="product">
         <div class="flex">
            <div class="price"><?= $fetch_products['product_price']; ?><span> VND</span></div>
            <div class="category"><?= $fetch_products['category_name']; ?></div>
         </div>
         <div class="name">
            <?= $fetch_products['product_name']; ?>
         </div>
         <div class="flex-btn">
            <a href="update_product.php?update=<?= $fetch_products['id_product']; ?>" class="option-btn">update</a>
            <a href="products.php?delete=<?= $fetch_products['id_product']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
         </div>
      </div>
         <?php
         }
            }else{
               echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </div>
   </div>

</section>

<script src="../js/admin_script.js"></script>
</body>
</html>