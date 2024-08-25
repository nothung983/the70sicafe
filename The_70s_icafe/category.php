<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_user'])){
   $user_id = $_SESSION['id_user'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Category</title>
   <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link  href="./css/style.css" rel="stylesheet">

</head>
<body>
<?php include 'components/user_header.php'; ?>

<section class="products">
   <?php
      $category = $_GET['category'];
      $select_cat = $conn->prepare("SELECT * FROM catergory WHERE id_catergory = ?");
      $select_cat->execute([$category]);
      $fetch_cat = $select_cat->fetch(PDO::FETCH_ASSOC)
   ?>
   <h1 class="title"><?= $fetch_cat['category_name'];?> Category</h1>

   <div class="box-container">
      <?php
         $category = $_GET['category'];
         $select_products = $conn->prepare("SELECT * FROM products WHERE id_catergory = ?");
         $select_products->execute([$category]);
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form method="post" class="box">
         <input type="hidden" id="pid" name="pid" value="<?= $fetch_products['id_product']; ?>">
         <input type="hidden" id="name" name="name" value="<?= $fetch_products['product_name']; ?>">
         <input type="hidden" id="price" name="price" value="<?= $fetch_products['product_price']; ?>">
         <input type="hidden" id="image" name="image" value="<?= $fetch_products['product_image']; ?>">

         <a href="quick_view.php?pid=<?= $fetch_products['id_product']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['product_image']; ?>" alt="">
         <div class="name"><?= $fetch_products['product_name']; ?></div>
         <div class="flex">
            <div class="price"><?= $fetch_products['product_price']; ?><span>VND</span></div>
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>
   </div>
</section>
<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>