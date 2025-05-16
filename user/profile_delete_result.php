<?php
   include '../dbconn.php';
   
   $user_id = $_POST["user_id"];
   
   // 트랜잭션 시작
   mysqli_begin_transaction($con);
   
   try {
       // 해당 사용자와 관련된 ChatMessages 삭제
       $sql1 = "DELETE FROM ChatMessages WHERE sender_id = '".$user_id."'";
       mysqli_query($con, $sql1);
       
       // 해당 사용자의 아이템과 관련된 ChatMessages 삭제
       $sql2 = "DELETE FROM ChatMessages WHERE item_id IN (SELECT item_id FROM Items WHERE seller_id = '".$user_id."')";
       mysqli_query($con, $sql2);
       
       // 해당 사용자의 Items 삭제
       $sql3 = "DELETE FROM Items WHERE seller_id = '".$user_id."'";
       mysqli_query($con, $sql3);
       
       // 최종적으로 사용자 삭제
       $sql4 = "DELETE FROM Users WHERE user_id = '".$user_id."'";
       $ret = mysqli_query($con, $sql4);
       
       // 성공하면 커밋
       mysqli_commit($con);
       
       echo "<h1> 회원 탈퇴 완료 </h1>";
       echo "회원 탈퇴가 성공적으로 처리되었습니다.<br>";
       echo "그동안 당근마켓을 이용해주셔서 감사합니다.";
   } catch (Exception $e) {
       // 실패하면 롤백
       mysqli_rollback($con);
       
       echo "<h1> 회원 탈퇴 실패 </h1>";
       echo "회원 탈퇴 중 오류가 발생했습니다.<br>";
       echo "실패 원인 :".mysqli_error($con);
   }
   
   mysqli_close($con);
   
   echo "<br><br> <a href='../main.html'> 초기 화면으로 돌아가기</a> ";
?>