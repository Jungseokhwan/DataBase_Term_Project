<?php
   include '../dbconn.php';

   $name = $_POST["name"];
   
   $sql = "INSERT INTO Categories (name) VALUES ('".$name."')";
   
   $ret = mysqli_query($con, $sql);
 
   echo "<h1> 신규 카테고리 입력 결과 </h1>";
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