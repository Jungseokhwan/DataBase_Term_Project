<?php
   include '../dbconn.php';

   $item_id = $_POST["item_id"];
   $sender_id = $_POST["sender_id"];
   $message_text = $_POST["message_text"];
   
   $sql = "INSERT INTO ChatMessages (item_id, sender_id, message_text) 
           VALUES ('".$item_id."', '".$sender_id."', '".$message_text."')";
   
   $ret = mysqli_query($con, $sql);
 
   if(!$ret) {
       echo "메시지 전송 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
   } 
   
   mysqli_close($con);
   
   // 채팅 페이지로 리다이렉트
   header("Location: chat.php?item_id=".$item_id);
?>