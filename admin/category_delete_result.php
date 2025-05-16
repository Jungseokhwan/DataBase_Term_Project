<?php
   include '../dbconn.php';
   
   $category_id = $_POST["category_id"];
   
   // 트랜잭션 시작
   mysqli_begin_transaction($con);
   
   try {
       // 해당 카테고리와 관련된 아이템의 채팅 메시지 삭제
       $sql1 = "DELETE FROM ChatMessages WHERE item_id IN (SELECT item_id FROM Items WHERE category_id = '".$category_id."')";
       mysqli_query($con, $sql1);
       
       // 해당 카테고리와 관련된 아이템 삭제
       $sql2 = "DELETE FROM Items WHERE category_id = '".$category_id."'";
       mysqli_query($con, $sql2);
       
       // 최종적으로 카테고리 삭제
       $sql3 = "DELETE FROM Categories WHERE category_id = '".$category_id."'";
       $ret = mysqli_query($con, $sql3);
       
       // 성공하면 커밋
       mysqli_commit($con);
       
       echo "<h1> 카테고리 삭제 결과 </h1>";
       echo $category_id." 카테고리가 성공적으로 삭제됨..";
   } catch (Exception $e) {
       // 실패하면 롤백
       mysqli_rollback($con);
       
       echo "<h1> 카테고리 삭제 결과 </h1>";
       echo "데이터 삭제 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
   }
   
   mysqli_close($con);
   
   echo "<br><br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>