<?php
   include '../dbconn.php';

   $sql = "SELECT * FROM Users";
 
   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
   }
   else {
       echo "Users 데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       exit();
   } 
   
   echo "<h1> 사용자 목록 </h1>";
   echo "<TABLE border=1>";
   echo "<TR>";
   echo "<TH>ID</TH><TH>사용자명</TH><TH>지역</TH><TH>가입일</TH><TH>수정</TH><TH>삭제</TH>";
   echo "</TR>";
   
   while($row = mysqli_fetch_array($ret)) {
      echo "<TR>";
      echo "<TD>", $row['user_id'], "</TD>";
      echo "<TD>", $row['username'], "</TD>";
      echo "<TD>", $row['region'], "</TD>";
      echo "<TD>", $row['created_at'], "</TD>";
      echo "<TD>", "<a href='user_update.php?user_id=", $row['user_id'], "'>수정</a></TD>";
      echo "<TD>", "<a href='user_delete.php?user_id=", $row['user_id'], "'>삭제</a></TD>";
      echo "</TR>";	  
   }   
   mysqli_close($con);
   echo "</TABLE>"; 
   echo "<br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>