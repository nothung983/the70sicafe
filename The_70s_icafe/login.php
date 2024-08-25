<?php

include 'components/connect.php';

   session_start();

   if(isset($_SESSION['id_user'])){
      $user_id = $_SESSION['id_user'];
   }else{
      $user_id = '';
   };

   if(isset($_POST['submit'])){

      $email = $_POST['user_email'];
      $pass = md5($_POST['user_password']);

      $select_user = $conn->prepare("SELECT * FROM `users` WHERE user_email = ? AND user_password = ?");
      $select_user->execute([$email, $pass]);
      $row = $select_user->fetch(PDO::FETCH_ASSOC);

      if($select_user->rowCount() > 0){
         $_SESSION['id_user'] = $row['id_user'];
         header('location:home.php');
      }else{
         $message[] = 'Incorrect user email or password!';
      }

   }

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login</title>
      <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
      <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link  href="./css/style.css" rel="stylesheet">
   </head>
   <body>
      <?php include 'components/user_header.php'; ?>
   <section class="form-container">
      <form method="post">
         <h3>login now</h3>
         <input type="email" id="user_email" name="user_email" required placeholder="enter your email" class="box" maxlength="50">
         <input type="password" id="user_password" name="user_password" required placeholder="enter your password" class="box" maxlength="50">
         <input type="submit" value="login now" name="submit" class="btn">
         <p>Don't have an account? <a href="register.php">Register now</a></p>
      </form>
   </section>
   <script src="js/script.js"></script>
   </body>
   <footer>
      <?php include 'components/footer.php'; ?>
   </footer>
</html>