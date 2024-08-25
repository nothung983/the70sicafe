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
   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $old_image = $_POST['old_image'];
   if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
       $image = $_FILES['image']['name'];
       $image_size = $_FILES['image']['size'];
       $image_tmp_name = $_FILES['image']['tmp_name'];
       $image_folder = './uploaded_img/user/'.$image;

       if($image_size > 20000000){
           $message[] = 'Images size is too large!';
       }else{
           $update_image = $conn->prepare("UPDATE users SET user_image = ? WHERE id_user = ?");
           $update_image->execute([$image, $user_id]);
           move_uploaded_file($image_tmp_name, $image_folder);
           unlink('./uploaded_img/user/'.$old_image);
           $message[] = 'Image updated!';
       }
   }
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
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Update Profile</title>
      <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
      <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link  href="./css/style.css" rel="stylesheet">
   </head>
   <body>
      <?php include 'components/user_header.php'; ?>
      <section class="form-container update-form">

         <form method="POST" enctype="multipart/form-data">
            <h3>Update profile</h3>
            <input type="hidden" id="old_image" name="old_image" value="<?= $fetch_profile['user_image']; ?>">
            <img src="./uploaded_img/user/<?= $fetch_profile['user_image']; ?>" alt="">
            <input type="text" id="name" name="name" placeholder="<?= $fetch_profile['username']; ?>" class="box" maxlength="50">
            <input type="email" id="email" name="email" placeholder="<?= $fetch_profile['user_email']; ?>" class="box" maxlength="50">
            <input type="text" id="number" name="number" placeholder="<?= $fetch_profile['user_phone_number']; ?>" class="box" maxlength="10">
            <input type="file" name="image" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
            <a href="change_pass.php" class="btn">Change password</a>
            <input type="submit" value="update" name="submit" class="btn">
         </form>
      </section>

      <?php include 'components/footer.php'; ?>
      <script src="js/check_user_info.js"></script>
      <script src="js/script.js"></script>
   </body>
</html>