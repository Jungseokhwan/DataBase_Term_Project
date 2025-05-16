<?php
   include '../dbconn.php';
   
   $message_id = $_POST["message_id"];
   
   $sql = "DELETE FROM ChatMessages WHERE message_id = '".$message_id."'";
   
   $ret = mysqli_query($con, $sql);
 
   echo "<h1> 채팅 삭제 결과 </h1>";
   if($ret) {
       echo $message_id." 채팅이 성공적으로 삭제됨..";
   }
   else {
       echo "데이터 삭제 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
   } 
   mysqli_close($con);
   
   echo "<br><br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>