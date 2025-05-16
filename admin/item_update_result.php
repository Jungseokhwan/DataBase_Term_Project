<?php
   include '../dbconn.php';

   $item_id = $_POST["item_id"];
   $seller_id = $_POST["seller_id"];
   $category_id = $_POST["category_id"];
   $title = $_POST["title"];
   $price = $_POST["price"];
   $status = $_POST["status"];
   $posted_at = $_POST["posted_at"];
   
   $sql = "UPDATE Items SET 
           seller_id='".$seller_id."', 
           category_id='".$category_id."', 
           title='".$title."', 
           price='".$price."', 
           status='".$status."', 
           posted_at='".$posted_at."' 
           WHERE item_id='".$item_id."'";
   
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
   
   echo "<br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>