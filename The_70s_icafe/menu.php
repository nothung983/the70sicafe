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
   <title>Menu</title>
   <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link  href="./css/style.css" rel="stylesheet">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>our menu</h3>
   <p><a href="home.php">Home</a> <span> / </span><a href="menu.php">Menu</a></p>
</div>

<section class="products">
   <h1 class="title">latest drinks</h1>
   <div class="box-container">
      <?php
         $select_products = $conn->prepare("SELECT * FROM products JOIN catergory ON products.id_catergory = catergory.id_catergory");
         $select_products->execute();
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
         <a href="category.php?category=<?= $fetch_products['id_catergory'];?>" class="cat"><?= $fetch_products['category_name']; ?></a>
         <div class="name"><?= $fetch_products['product_name']; ?></div>
         <div class="flex">
            <div class="price"><?= $fetch_products['product_price']; ?><span>VND</span></div>
            <input type="number" id="qty" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">No products added yet!</p>';
         }
      ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>