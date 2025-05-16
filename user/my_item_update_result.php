<?php
   include '../dbconn.php';

   $item_id = $_POST["item_id"];
   $seller_id = $_POST["seller_id"];
   $category_id = $_POST["category_id"];
   $title = $_POST["title"];
   $price = $_POST["price"];
   $status = $_POST["status"];
   
   $sql = "UPDATE Items SET 
           category_id='".$category_id."', 
           title='".$title."', 
           price='".$price."', 
           status='".$status."' 
           WHERE item_id='".$item_id."' AND seller_id='".$seller_id."'";
   
   $ret = mysqli_query($con, $sql);
 
    echo "<h1> 상품 정보 수정 결과 </h1>";
   if($ret) {
       echo "데이터가 성공적으로 수정됨.";
   }
   else {
       echo "데이터 수정 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
   } 
   mysqli_close($con);
   
   echo "<br> <a href='my_items.php'> <--내가 쓴 글로 돌아가기</a> ";
?>