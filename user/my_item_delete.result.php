<?php
   include '../dbconn.php';
   
   $item_id = $_POST["item_id"];
   $seller_id = $_POST["seller_id"];
   
   // 트랜잭션 시작
   mysqli_begin_transaction($con);
   
   try {
       // 먼저 현재 사용자가 이 상품의 판매자인지 확인
       $sql_check = "SELECT * FROM Items WHERE item_id = '".$item_id."' AND seller_id = '".$seller_id."'";
       $ret_check = mysqli_query($con, $sql_check);
       
       if(mysqli_num_rows($ret_check) == 0) {
           throw new Exception("삭제 권한이 없습니다.");
       }
       
       // 해당 상품과 관련된 ChatMessages 삭제
       $sql1 = "DELETE FROM ChatMessages WHERE item_id = '".$item_id."'";
       mysqli_query($con, $sql1);
       
       // 상품 삭제
       $sql2 = "DELETE FROM Items WHERE item_id = '".$item_id."' AND seller_id = '".$seller_id."'";
       $ret = mysqli_query($con, $sql2);
       
       // 성공하면 커밋
       mysqli_commit($con);
       
       echo "<h1> 상품 삭제 결과 </h1>";
       echo "상품이 성공적으로 삭제되었습니다.";
   } catch (Exception $e) {
       // 실패하면 롤백
       mysqli_rollback($con);
       
       echo "<h1> 상품 삭제 결과 </h1>";
       echo "상품 삭제 실패!!!"."<br>";
       echo "실패 원인 : ".$e->getMessage();
   }
   
   mysqli_close($con);
   
   echo "<br><br> <a href='my_items.php'> <--내가 쓴 글로 돌아가기</a> ";
?>