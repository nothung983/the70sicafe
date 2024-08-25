<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['id_admin'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id_message = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Messages</title>
      <link rel="icon" type="image/x-icon" href="../images/TITLE.ico">
      <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link href="../css/admin_style.css" rel="stylesheet">
   </head>
   <body>

   <?php include '../components/admin_header.php' ?>

   <section class="messages">

      <h1 class="heading">messages</h1>

      <div class="box-container">

      <?php
         $select_messages = $conn->prepare("SELECT * FROM messages JOIN users ON messages.id_user = users.id_user ");
         $select_messages->execute();
         if($select_messages->rowCount() > 0){
            while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p> Username : <span><?= $fetch_messages['username']; ?></span> </p>
         <p> Number : <span><?= $fetch_messages['user_phone_number']; ?></span> </p>
         <p> Email : <span><?= $fetch_messages['user_email']; ?></span> </p>
         <p> Message : <span><?= $fetch_messages['message_details']; ?></span> </p>
         <a href="messages.php?delete=<?= $fetch_messages['id_message']; ?>" class="delete-btn" 
         onclick="return confirm('delete this message?');">delete</a>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty">you have no messages</p>';
         }
      ?>
      </div>
   </section>
   <script src="../js/admin_script.js"></script>
   </body>
</html>