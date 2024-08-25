<?php
   if(isset($_POST['add_to_cart'])){

      if($user_id == ''){
         header('location:login.php');
      }else{

         $user_id = $_SESSION['id_user'];
         $pid = $_POST['pid'];
         $qty = $_POST['qty'];

         $check_cart_numbers = $conn->prepare("SELECT * FROM cart WHERE id_product= ? AND id_user = ?");
         $check_cart_numbers->execute([$pid, $user_id]);

         if($check_cart_numbers->rowCount() > 0){
            $message[] = 'Already added to cart!';
         }else{
            $insert_cart = $conn->prepare("INSERT INTO cart(id_user, id_product, quantity) VALUES(?,?,?)");
            $insert_cart->execute([$user_id, $pid, $qty]);
            $message[] = 'Added to cart!';
         }
      }
   }
?>