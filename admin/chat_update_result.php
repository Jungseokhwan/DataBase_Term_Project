<?php
   include '../dbconn.php';

   $message_id = $_POST["message_id"];
   $item_id = $_POST["item_id"];
   $sender_id = $_POST["sender_id"];
   $message_text = $_POST["message_text"];
   $sent_at = $_POST["sent_at"];
   
   $sql = "UPDATE ChatMessages SET 
           item_id='".$item_id."', 
           sender_id='".$sender_id."', 
           message_text='".$message_text."', 
           sent_at='".$sent_at."' 
           WHERE message_id='".$message_id."'";
   
   $ret = mysqli_query($con, $sql);
 
    echo "<h1> 채팅 정보 수정 결과 </h1>";
   if($ret) {
       echo "데이터가 성공적으로 수정됨.";
   }
   else {
       echo "데이터 수정 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
   } 
   mysqli_close($con);
   
   echo "<br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>