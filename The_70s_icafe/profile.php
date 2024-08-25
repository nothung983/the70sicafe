<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_user'])){
   $user_id = $_SESSION['id_user'];
}else{
   $user_id = '';
   header('location:home.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>
   <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link  href="./css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'components/user_header.php'; ?>
<section class="user-details">
   <div class="user">
      <div class="user-image">
         <img src="./uploaded_img/user/<?= $fetch_profile['user_image']; ?>" alt="">
      </div>
      <p><i class="fas fa-user"></i><span><span><?= $fetch_profile['username']; ?></span></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['user_phone_number']; ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['user_email']; ?></span></p>
      <a href="update_profile.php" class="btn">update info</a>
      <p class="address">
         <i class="fas fa-map-marker-alt"></i>
            <span><?php if($fetch_profile['user_address'] == ''){
            echo 'please enter your address';
            }else{
               echo $fetch_profile['user_address'];
               } ?>
               </span>
      </p>
      <a href="update_address.php" class="btn">update address</a>
   </div>
</section>

<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>