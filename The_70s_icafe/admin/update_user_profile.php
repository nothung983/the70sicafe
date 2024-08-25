<?php

include '../components/connect.php';
session_start();
$admin_id = $_SESSION['id_admin'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['updt_usr_id'])){

   $user_id = $_GET['updt_usr_id'];

   if(isset($_POST['submit'])){

      $name = $_POST['name'];
      $email = $_POST['email'];
      $number = $_POST['number'];
      
      if(!empty($name)){
         $update_name = $conn->prepare("UPDATE users SET username = ? WHERE id_user = ?");
         $update_name->execute([$name, $user_id]);
      }
      if(!empty($email)){
         $select_email = $conn->prepare("SELECT * FROM users WHERE user_email = ?");
         $select_email->execute([$email]);
         if($select_email->rowCount() > 0){
            $message[] = 'Email already taken!';
         }else{
            $update_email = $conn->prepare("UPDATE users SET user_email = ? WHERE id_user = ?");
            $update_email->execute([$email, $user_id]);
         }
      }

      if(!empty($number)){
         $select_number = $conn->prepare("SELECT * FROM users WHERE user_phone_number = ?");
         $select_number->execute([$number]);
         if($select_number->rowCount() > 0){
            $message[] = 'Number already taken!';
         }else{
            $update_number = $conn->prepare("UPDATE users SET user_phone_number = ? WHERE id_user = ?");
            $update_number->execute([$number, $user_id]);
         }
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
      <title>Update User Profile</title>
      <link rel="icon" type="image/x-icon" href="../images/TITLE.ico">
      <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link  href="../css/admin_style.css" rel="stylesheet">
   </head>
   <body>
      <?php include '../components/admin_header.php'; ?>
      <section class="form-container update-form">

         <form method="POST" enctype="multipart/form-data">
            <h3>Update profile</h3>
            <?php
               $user_data = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
               $user_data->execute([$user_id]);
               $fetch_account = $user_data->fetch(PDO::FETCH_ASSOC);
            ?>
            <input type="hidden" id="image" name="image" value="<?= $fetch_account['user_image']; ?>">
            <img src="../uploaded_img/user/<?= $fetch_account['user_image']; ?>" alt="">
            <input type="text" id="name" name="name" placeholder="<?= $fetch_account['username']; ?>" class="box" maxlength="50">
            <input type="email" id="email" name="email" placeholder="<?= $fetch_account['user_email']; ?>" class="box" maxlength="50">
            <input type="text" id="number" name="number" placeholder="<?= $fetch_account['user_phone_number']; ?>" class="box" maxlength="10">
            <a href="change_user_pass.php?new_pass_id=<?= $fetch_account['id_user'];?>" class="btn">Change password</a>
            <input type="submit" value="update" name="submit" class="btn">
         </form>
      </section>

      <?php include '../components/footer.php'; ?>
      <script src="js/check_user_register.js"></script>
      <script src="js/script.js"></script>
   </body>
</html>