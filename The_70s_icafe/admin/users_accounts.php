<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['id_admin'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];   
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id_user = ?");
   $delete_order->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id_user = ?");
   $delete_cart->execute([$delete_id]);
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id_user = ?");
   $delete_users->execute([$delete_id]);
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users accounts</title>
   <link rel="icon" type="image/x-icon" href="../images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link href="../css/admin_style.css" rel="stylesheet">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="accounts">

   <h1 class="heading">users account</h1>

   <div class="box-container">
   <?php
      $select_account = $conn->prepare("SELECT * FROM `users`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <p> User ID : <span><?= $fetch_accounts['id_user']; ?></span> </p>
      <p> Username : <span><?= $fetch_accounts['username']; ?></span> </p>
      <div class="flex-btn">
         <a href="update_user_profile.php?updt_usr_id=<?= $fetch_accounts['id_user']; ?>" class="option-btn">update</a>
         <a href="users_accounts.php?delete=<?= $fetch_accounts['id_user']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">delete</a>
      </div>
      
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">No accounts available</p>';
   }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>