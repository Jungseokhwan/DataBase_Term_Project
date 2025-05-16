<?php
   include '../dbconn.php';

   $item_id = $_POST["item_id"];
   $sender_id = $_POST["sender_id"];
   $message_text = $_POST["message_text"];
   
   $sql = "INSERT INTO ChatMessages (item_id, sender_id, message_text) 
           VALUES ('".$item_id."', '".$sender_id."', '".$message_text."')";
   
   $ret = mysqli_query($con, $sql);
 
   echo "<h1> 신규 채팅 입력 결과 </h1>";
   if($ret) {
       echo "데이터가 성공적으로 입력됨.";
   }
   else {
       echo "데이터 입력 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
   } 
   mysqli_close($con);
   
   echo "<br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>