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

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $new_pass = md5($_POST['new_pass']);
   $confirm_pass = md5($_POST['confirm_pass']);

    if($new_pass != $empty_pass && $new_pass == $confirm_pass){
        $update_pass = $conn->prepare("UPDATE users SET user_password = ? WHERE id_user = ?");
        $update_pass->execute([$confirm_pass, $user_id]);
        $message[] = 'Password updated successfully!';
    }elseif($new_pass != $confirm_pass){
        $message[] = 'Confirm password not matched!';
    }else{
        $message[] = 'Please enter a new password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Change password</title>
   <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link  href="./css/style.css" rel="stylesheet">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container update-form">

   <form method="post">
      <h3>Update password</h3>
      <input type="password" id="new_pass" name="new_pass" placeholder="enter your new password" class="box" maxlength="50">
      <input type="password" id="confirm_pass" name="confirm_pass" placeholder="confirm your new password" class="box" maxlength="50">
      <a href="update_profile.php" class="delete-btn">Back</a>
      <input type="submit" value="update password" name="submit" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>
<script src="js/check_pass.js"></script>
<script src="js/script.js"></script>

</body>
</html>