<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['id_admin'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_payment'])){

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id_order = ?");
   $update_status->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id_order = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Placed orders</title>
   <link rel="icon" type="image/x-icon" href="../images/TITLE.ico">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <link href="../css/admin_style.css" rel="stylesheet">
</head>
<body>

<?php include '../components/admin_header.php' ?>
<section class="placed-orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM orders JOIN users ON orders.id_user = users.id_user ");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Order Id : <span><?= $fetch_orders['id_order']; ?></span> </p>
      <p> Placed On : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Name : <span><?= $fetch_orders['username']; ?></span> </p>
      <p> Email : <span><?= $fetch_orders['user_email']; ?></span> </p>
      <p> Number : <span><?= $fetch_orders['user_phone_number']; ?></span> </p>
      <p> Address : <span><?= $fetch_orders['user_address']; ?></span> </p>
      <p> Total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Total price : <span><?= $fetch_orders['total_price']; ?> VND</span> </p>
      <p> Payment method : <span><?= $fetch_orders['payment_method']; ?></span> </p>
      <form method="POST">
         <input type="hidden" id="order_id" name="order_id" value="<?= $fetch_orders['id_order']; ?>">
         <select name="payment_status" class="drop-down">
            <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">pending</option>
            <option value="completed">completed</option>
         </select>
         <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="update_payment">
            <a href="placed_orders.php?delete=<?= $fetch_orders['id_order']; ?>" 
            class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
         </div>
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
   }
   ?>

   </div>

</section>
<script src="../js/admin_script.js"></script>

</body>
<footer>
      <?php include '../components/footer.php'; ?>
</footer>
</html>