<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['id_admin'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $pass = md5($_POST['pass']);
   $cpass = md5($_POST['cpass']);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE ad_name = ?");
   $select_admin->execute([$name]);
   
   if($select_admin->rowCount() > 0){
      $message[] = 'Username already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm passowrd not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admin`(ad_name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'New admin registered!';
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
      <h3>Register new admin</h3>
      <input type="text" id="name" name="name" required placeholder="enter your username" class="box">
      <input type="password" id="pass" name="pass" required placeholder="enter your password" class="box">
      <input type="password" id="cpass" name="cpass" required placeholder="confirm your password" class="box">
      <input type="submit" value="register now" name="submit" class="btn">
   </form>

</section>
<script src="../js/check_admin_info.js"></script>
<script src="../js/admin_script.js"></script>

</body>
<footer>
   <?php include '../components/footer.php'; ?>
</footer>
</html>