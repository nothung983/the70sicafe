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
      <title>Home</title>
      <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
      <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link  href="./css/style.css" rel="stylesheet">
   </head>
   <body>

   <?php require 'components/user_header.php'; ?>
   <section class="hero">
      <div class="swiper hero-slider">
         <div class="swiper-wrapper">
            <div class="swiper-slide slide">
               <div class="content">
                  <span>Order online</span>
                  <h3>Fruit tea</h3>
                  <a href="menu.php" class="btn">see menus</a>
               </div>
               <div class="image">
                  <img src="images/fruit-tea-2.png" alt="fruit tea">
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="content">
                  <span>Order online</span>
                  <h3>Milk tea</h3>
                  <a href="menu.php" class="btn">see menus</a>
               </div>
               <div class="image">
                  <img src="images/milk-tea.png" alt="milk tea">
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="content">
                  <span>Order online</span>
                  <h3>Coffee</h3>
                  <a href="menu.php" class="btn">see menus</a>
               </div>
               <div class="image">
                  <img src="images/coffee-den.png" alt="coffee">
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="content">
                  <span>Order online</span>
                  <h3>Freeze</h3>
                  <a href="menu.php" class="btn">see menus</a>
               </div>
               <div class="image">
                  <img src="images/freeze.png" alt="freeze">
               </div>
            </div>

         </div>
         <div class="swiper-pagination"></div>
      </div>

   </section>

   <section class="products">
      <h1 class="title">latest products</h1>
      <div class="box-container">

      <?php 
         $select_products = $conn->prepare("SELECT * FROM products JOIN catergory ON products.id_catergory = catergory.id_catergory LIMIT 6"); 
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
                  <a href="category.php?category=<?= $fetch_products['id_catergory']; ?>" class="cat"> <?= $fetch_products['category_name']; ?></a> 
                  <div class="name">
                     <?= $fetch_products['product_name']; ?>
                  </div> 
                  <div class="flex"> 
                     <div class="price">
                        <?= $fetch_products['product_price']; ?><span> VND</span>
                        <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
                     </div>
                  </div> 
            </form> 
            <?php 
            }
         }else{ 
            echo '<p class="empty">no products added yet!</p>'; 
         } 
      ?>
      </div>
      <div class="more-btn">
         <a href="menu.php" class="btn">View all</a>
      </div>
   </section>

   <?php include 'components/info.php'; ?>
   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <script src="js/script.js"></script>
   <script>
      var swiper = new Swiper(".hero-slider", {
         loop:true,
         grabCursor: true,
         effect: "swipe",
         pagination: {
            el: ".swiper-pagination",
            clickable:true,
         },
      });
   </script>

   </body>
   <footer>
      <?php include 'components/footer.php'; ?>
   </footer>
</html>