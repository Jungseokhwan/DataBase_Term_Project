<?php
   include '../dbconn.php';

   $user_id = $_POST["user_id"];
   $username = $_POST["username"];
   $region = $_POST["region"];
   $created_at = $_POST["created_at"];
   
   $sql = "UPDATE Users SET username='".$username."', region='".$region."', created_at='".$created_at."' WHERE user_id='".$user_id."'";
   
   $ret = mysqli_query($con, $sql);
 
    echo "<h1> 사용자 정보 수정 결과 </h1>";
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