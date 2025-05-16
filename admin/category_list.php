<?php
   include '../dbconn.php';

   $sql = "SELECT * FROM Categories";
 
   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
   }
   else {
       echo "Categories 데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       exit();
   } 
   
   echo "<h1> 카테고리 목록 </h1>";
   echo "<TABLE border=1>";
   echo "<TR>";
   echo "<TH>카테고리 ID</TH><TH>카테고리명</TH><TH>수정</TH><TH>삭제</TH>";
   echo "</TR>";
   
   while($row = mysqli_fetch_array($ret)) {
      echo "<TR>";
      echo "<TD>", $row['category_id'], "</TD>";
      echo "<TD>", $row['name'], "</TD>";
      echo "<TD>", "<a href='category_update.php?category_id=", $row['category_id'], "'>수정</a></TD>";
      echo "<TD>", "<a href='category_delete.php?category_id=", $row['category_id'], "'>삭제</a></TD>";
      echo "</TR>";	  
   }   
   mysqli_close($con);
   echo "</TABLE>"; 
   echo "<br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>