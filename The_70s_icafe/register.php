<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_user'])){
   $user_id = $_SESSION['id_user'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $pass = md5($_POST['pass']);
   $cpass = md5($_POST['cpass']);

   $select_user = $conn->prepare("SELECT * FROM users WHERE user_email = ? OR user_phone_number = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email or number already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(username, user_email, user_phone_number, user_password) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $cpass]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE user_email = ? AND user_password = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['id_user'] = $row['id_user'];
            header('location:home.php');
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
   <title>Register</title>
   <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link  href="./css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="form-container">
   <form method="POST">
      <h3>register now</h3>
      <input type="text" id="name" name="name" required placeholder="enter your name" class="box" maxlength="50">
      <input type="email" id="email" name="email" required placeholder="enter your email" class="box" maxlength="50">
      <input type="text" id="number" name="number" required placeholder="enter your phone number" class="box" maxlength="10">
      <input type="password" id="pass" name="pass" required placeholder="enter your password" class="box" maxlength="50" >
      <input type="password" id="cpass" name="cpass" required placeholder="confirm your password" class="box" maxlength="50" >
      <input type="submit" value="register now" name="submit" class="btn">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</section>

<?php include 'components/footer.php'; ?>
<script src="js/check_user_register.js"></script>
<script src="js/script.js"></script>

</body>
</html>