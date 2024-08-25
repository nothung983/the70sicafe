<?php

include '../components/connect.php';
session_start();
$admin_id = $_SESSION['id_admin'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];

   if(!empty($name)){
      $select_name = $conn->prepare("SELECT * FROM `admin` WHERE ad_name = ?");
      $select_name->execute([$name]);
      if($select_name->rowCount() > 0){
         $message[] = 'Username already used by another user!';
      }else{
         $update_name = $conn->prepare("UPDATE `admin` SET ad_name = ? WHERE id_admin = ?");
         $update_name->execute([$name, $admin_id]);
      }
   }

   $empty_pass = '81dc9bdb52d04dc20036dbd8313ed055'; //1234
   $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id_admin = ?");
   $select_old_pass->execute([$admin_id]);
   $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];
   $old_pass = md5($_POST['old_pass']);
   $new_pass = md5($_POST['new_pass']);
   $confirm_pass = md5($_POST['confirm_pass']);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'Old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'Confirm password not matched!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id_admin = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'Password updated successfully!';
         }else{
            $message[] = 'Please enter a new password!';
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
   <title>Profile Update</title>
   <link rel="icon" type="image/x-icon" href="../images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link href="../css/admin_style.css" rel="stylesheet">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="form-container">

   <form method="POST">
      <h3>update profile</h3>
      <input type="text" id="name" name="name" class="box" placeholder="<?= $fetch_profile['ad_name']; ?>">
      <input type="password" id="old_pass" name="old_pass" placeholder="enter your old password" class="box">
      <input type="password" id="new_pass" name="new_pass" placeholder="enter your new password" class="box">
      <input type="password" id="confirm_pass" name="confirm_pass" placeholder="confirm your new password" class="box">
      <input type="submit" value="update now" name="submit" class="btn">
   </form>

</section>

<script src="../js/check_admin_update.js"></script>
<script src="../js/admin_script.js"></script>

</body>
</html>