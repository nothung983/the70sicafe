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
      <title>Search page</title>   
      <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
      <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link  href="./css/style.css" rel="stylesheet">

   </head>
   <body>
         <?php include 'components/user_header.php'; ?>
         <section class="search-form">
            <form method="POST">
               <input type="text" name="search_box" placeholder="search for products here..." class="box">
               <button type="submit" name="search_btn" class="fas fa-search"></button>
            </form>
         </section>
         <section class="products" style="min-height: 100vh; padding-top:0;">
         <div class="box-container">
               <?php
                  if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
                  $search_box = $_POST['search_box'];
                  $select_products = $conn->prepare("SELECT * FROM products JOIN catergory ON 
                                                      products.id_catergory=catergory.id_catergory WHERE product_name LIKE '%{$search_box}%'");
                  $select_products->execute();
                  if($select_products->rowCount() > 0){
                     while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
               ?>
               <form method="POST" class="box">
                  <input type="hidden" id="pid" name="pid" value="<?= $fetch_products['id_product']; ?>">
                  <input type="hidden" id="name" name="name" value="<?= $fetch_products['product_name']; ?>">
                  <input type="hidden" id="price" name="price" value="<?= $fetch_products['product_price']; ?>">
                  <input type="hidden" id="image" name="image" value="<?= $fetch_products['product_image']; ?>">
                  <a href="quick_view.php?pid=<?= $fetch_products['id_product']; ?>" class="fas fa-eye"></a>
                  <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                  <img src="uploaded_img/<?= $fetch_products['product_image']; ?>" alt="">
                  <a href="category.php?category=<?= $fetch_products['id_catergory']; ?>" class="cat"><?= $fetch_products['category_name']; ?></a>
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
               }
               ?>

         </div>

      </section>

      <script src="js/script.js"></script>
   </body>
   <footer>
      <?php include 'components/footer.php'; ?>
   </footer>
</html>