<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id_user'])){
   $user_id = $_SESSION['id_user'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){
   $msg = $_POST['msg'];
   $select_message = $conn->prepare("SELECT * FROM messages JOIN users ON messages.id_user=users.id_user WHERE messages.id_user = ? AND messages.message_details = ?");
   $select_message->execute([$user_id, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'Already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO messages(id_user, message_details) VALUES(?,?)");
      $insert_message->execute([$user_id, $msg]);
      $message[] = 'Sent message successfully!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Contact</title>
      <link rel="icon" type="image/x-icon" href="images/TITLE.ico">
      <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link  href="./css/style.css" rel="stylesheet">
   </head>
   <body>

      <?php include 'components/user_header.php'; ?>
      <div class="heading">
         <h3>contact us</h3>
         <p><a href="home.php">Home</a> <span> / </span> <a href="contact.php">Contact</a> </p>
      </div>
      <section class="contact">
         <div class="row">
            <div class="image">
               <img src="images/message.gif" alt="msg gif">
            </div>
            <form method="POST">
               <h3>Tell us something!</h3>
               <textarea name="msg" class="box" required placeholder="enter your message" maxlength="500" cols="30" rows="10"></textarea>
               <p class="caution">Please <a href="login.php">login</a> or <a href="register.php">register</a> an account before sending any message </p>
               <input type="submit" value="send message" name="send" class="btn">
            </form>
         </div>
      </section>
      <?php include 'components/footer.php'; ?>
      <script src="js/script.js"></script>
   </body>
</html>