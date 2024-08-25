<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_user'])){
   $user_id = $_SESSION['id_user'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $method = $_POST['method'];
   $address = $_POST['address'];
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM cart WHERE id_user = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'please add your address!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO orders(id_user,payment_method, total_products, total_price) VALUES(?,?,?,?)");
         $insert_order->execute([$user_id, $method, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM cart WHERE id_user = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'order placed successfully!';
      }
      
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link  href="./css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>Checkout</h3>
   <p><a href="home.php">home</a> <span> / checkout</span></p>
</div>

<section class="checkout">

   <h1 class="title">order summary</h1>

   <form method="POST">

      <div class="cart-items">
         <h3>cart items</h3>
         <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM cart 
                                             JOIN products on cart.id_product = products.id_product
                                             WHERE id_user = ?");
            $select_cart->execute([$user_id]);
            if($select_cart->rowCount() > 0){
               while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                  $cart_items[] = $fetch_cart['product_name'].' ('.$fetch_cart['product_price'].' x '. $fetch_cart['quantity'].') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($fetch_cart['product_price'] * $fetch_cart['quantity']);
         ?>
         <p>
            <span class="name"><?= $fetch_cart['product_name']; ?></span>
            <span class="price"><?= $fetch_cart['quantity']; ?> x <?= $fetch_cart['product_price']; ?> VND</span>
         </p>
         <?php
               }
            }else{
               echo '<p class="empty">your cart is empty!</p>';
            }
         ?>
         <p class="grand-total">
            <span class="name">grand total :</span>
            <span class="price"><?= $grand_total; ?> VND</span>
         </p>
         <a href="cart.php" class="btn">Veiw cart</a>
      </div>

      <input type="hidden" id="total_products" name="total_products" value="<?= $total_products;?>">
      <input type="hidden" id="total_price" name="total_price" value="<?= $grand_total;?>">
      <input type="hidden" id="name" name="name" value="<?= $fetch_profile['username'] ?>">
      <input type="hidden" id="number" name="number" value="<?= $fetch_profile['user_phone_number'] ?>">
      <input type="hidden" id="email" name="email" value="<?= $fetch_profile['user_email'] ?>">
      <input type="hidden" id="address" name="address" value="<?= $fetch_profile['user_address'] ?>">

      <div class="user-info">
         <h3>your info</h3>
         <p><i class="fas fa-user"></i><span><?= $fetch_profile['username'] ?></span></p>
         <p><i class="fas fa-phone"></i><span><?= $fetch_profile['user_phone_number'] ?></span></p>
         <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['user_email'] ?></span></p>
         <a href="update_profile.php" class="btn">Update info</a>
         <h3>delivery address</h3>
         <p><i class="fas fa-map-marker-alt"></i>
            <span><?php if($fetch_profile['user_address'] == ''){
            echo 'please enter your address';
            }else{
               echo $fetch_profile['user_address'];
            } ?>
            </span>
         </p>
         <a href="update_address.php" class="btn">update address</a>
         <select name="method" class="box" required>
            <option value="" disabled selected>-Select Payment method-</option>
            <option value="Cash on delivery">Cash On Delivery (COD)</option>
            <option value="Credit card">Credit Card</option>
         </select>
         <input type="submit" value="place order" 
            class="btn <?php if($fetch_profile['user_address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
      </div>

   </form>
   
</section>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>