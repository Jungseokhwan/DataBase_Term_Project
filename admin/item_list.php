<?php
   include '../dbconn.php';

   $sql = "SELECT i.*, u.username, c.name as category_name 
           FROM Items i 
           JOIN Users u ON i.seller_id = u.user_id 
           JOIN Categories c ON i.category_id = c.category_id";
 
   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
   }
   else {
       echo "Items 데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       exit();
   } 
   
   echo "<h1> 상품 목록 </h1>";
   echo "<TABLE border=1>";
   echo "<TR>";
   echo "<TH>상품 ID</TH><TH>판매자</TH><TH>카테고리</TH><TH>제목</TH><TH>가격</TH><TH>상태</TH><TH>등록일</TH><TH>수정</TH><TH>삭제</TH>";
   echo "</TR>";
   
   while($row = mysqli_fetch_array($ret)) {
      echo "<TR>";
      echo "<TD>", $row['item_id'], "</TD>";
      echo "<TD>", $row['username'], "</TD>";
      echo "<TD>", $row['category_name'], "</TD>";
      echo "<TD>", $row['title'], "</TD>";
      echo "<TD>", $row['price'], "</TD>";
      echo "<TD>", $row['status'], "</TD>";
      echo "<TD>", $row['posted_at'], "</TD>";
      echo "<TD>", "<a href='item_update.php?item_id=", $row['item_id'], "'>수정</a></TD>";
      echo "<TD>", "<a href='item_delete.php?item_id=", $row['item_id'], "'>삭제</a></TD>";
      echo "</TR>";	  
   }   
   mysqli_close($con);
   echo "</TABLE>"; 
   echo "<br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>