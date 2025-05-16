<?php
   include '../dbconn.php';

   $category_id = $_POST["category_id"];
   $name = $_POST["name"];
   
   $sql = "UPDATE Categories SET name='".$name."' WHERE category_id='".$category_id."'";
   
   $ret = mysqli_query($con, $sql);
 
    echo "<h1> 카테고리 정보 수정 결과 </h1>";
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