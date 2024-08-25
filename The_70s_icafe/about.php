<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_user'])){
   $user_id = $_SESSION['id_user'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>  
   <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link  href="./css/style.css" rel="stylesheet">
</head>
<body>

<?php require 'components/user_header.php'; ?>

<div class="heading">
   <h3>About us</h3>
   <p><a href="home.php">Home</a> <span> / </span> <a href="about.php">About</a> </p>
</div>

<section class="about">
   <div class="row">
      <div class="image">
         <img src="images/khong_gian_quan_3.jpg" alt="coffee store bg">
      </div>

      <div class="content">
         <h3>Why choose us?</h3>
         <p>
            Experience nostalgia at our café, The 70s iCafe, where every sip transports you back to the groovy era. 
            Indulge in our retro ambiance, complete with vintage décor and classic tunes, for a truly memorable coffee experience.
         </p>
         <a href="menu.php" class="btn">Our menu</a>
      </div>
   </div>

</section>

<section class="steps">
   <h1 class="title">simple steps</h1>
   <div class="box-container">
      <div class="box">
         <img src="images/GIF/online-shop.gif" alt="">
         <h3>choose order</h3>
         <p>Pick a drink on our menu and place the order</p>
      </div>

      <div class="box">
         <img src="images/GIF/delivery-truck.gif" alt="">
         <h3>fast delivery</h3>
         <p>The drink will be ship to you as fast as it can</p>
      </div>

      <div class="box">
         <img src="images/GIF/people.gif" alt="">
         <h3>enjoy your drink</h3>
         <p>We are very happy to serve you the best drink that you want</p>
      </div>

   </div>

</section>
<script src="js/script.js"></script>
<?php include 'components/info.php'; ?>
<?php include 'components/footer.php'; ?>

</body>
</html>