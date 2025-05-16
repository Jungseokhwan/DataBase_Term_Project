<?php
   include '../dbconn.php';
   
   $item_id = $_POST["item_id"];
   
   // 트랜잭션 시작
   mysqli_begin_transaction($con);
   
   try {
       // 해당 상품과 관련된 ChatMessages 삭제
       $sql1 = "DELETE FROM ChatMessages WHERE item_id = '".$item_id."'";
       mysqli_query($con, $sql1);
       
       // 상품 삭제
       $sql2 = "DELETE FROM Items WHERE item_id = '".$item_id."'";
       $ret = mysqli_query($con, $sql2);
       
       // 성공하면 커밋
       mysqli_commit($con);
       
       echo "<h1> 상품 삭제 결과 </h1>";
       echo $item_id." 상품이 성공적으로 삭제됨..";
   } catch (Exception $e) {
       // 실패하면 롤백
       mysqli_rollback($con);
       
       echo "<h1> 상품 삭제 결과 </h1>";
       echo "데이터 삭제 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
   }
   
   mysqli_close($con);
   
   echo "<br><br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>