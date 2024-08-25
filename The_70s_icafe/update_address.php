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

   $address = $_POST['house_number'] .', '. $_POST['road'] .', '. $_POST['ward'] .', '. $_POST['district'] .', '. $_POST['city'];
   $update_address = $conn->prepare("UPDATE `users` set user_address = ? WHERE id_user = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'address saved!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update address</title>
   <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link  href="./css/style.css" rel="stylesheet">
</head>
<body>
   
<?php include 'components/user_header.php' ?>

<section class="form-container">

   <form method="POST">
      <h3>your address</h3>
      <input type="text" class="box" placeholder="your house number" required maxlength="255" name="house_number">
      <input type="text" class="box" placeholder="your road" required maxlength="255" name="road">
      <input type="text" class="box" placeholder="your ward" required maxlength="255" name="ward">
      <input type="text" class="box" placeholder="your district" required maxlength="255" name="district">
      <input type="text" class="box" placeholder="your city" required maxlength="255" name="city">
      <input type="submit" value="save address" name="submit" class="btn">
   </form>

</section>
<?php include 'components/footer.php' ?>
<script src="js/script.js"></script>

</body>
</html>