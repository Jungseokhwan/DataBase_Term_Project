<?php
   include '../dbconn.php';

   $seller_id = $_POST["seller_id"];
   $category_id = $_POST["category_id"];
   $title = $_POST["title"];
   $price = $_POST["price"];
   $status = $_POST["status"];
   
   $sql = "INSERT INTO Items (seller_id, category_id, title, price, status) 
           VALUES ('".$seller_id."', '".$category_id."', '".$title."', '".$price."', '".$status."')";
   
   $ret = mysqli_query($con, $sql);
 
   echo "<h1> 신규 상품 입력 결과 </h1>";
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