<?php
include '../components/connect.php';
session_start();
if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $pass = md5($_POST['password']);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE ad_name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   
   if($select_admin->rowCount() > 0){
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['id_admin'] = $fetch_admin_id['id_admin'];
      header('location:dashboard.php');
   }else{
      $message[] = 'Incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login</title>
   <link rel="icon" type="image/x-icon" href="../images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link href="../css/admin_style.css" rel="stylesheet">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<section class="form-container">

   <form method="POST">
      <h3>Admin Login</h3>
      <input type="text" id="name" name="name" required placeholder="enter your username" class="box">
      <input type="password" id="password" name="password" required placeholder="enter your password" class="box">
      <input type="submit" value="login now" name="submit" class="btn">
   </form>

</section>


</body>
</html>