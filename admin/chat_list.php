<?php
   include '../dbconn.php';

   $sql = "SELECT c.*, i.title, u.username 
           FROM ChatMessages c 
           JOIN Items i ON c.item_id = i.item_id 
           JOIN Users u ON c.sender_id = u.user_id";
 
   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
   }
   else {
       echo "ChatMessages 데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       exit();
   } 
   
   echo "<h1> 채팅 목록 </h1>";
   echo "<TABLE border=1>";
   echo "<TR>";
   echo "<TH>메시지 ID</TH><TH>상품</TH><TH>보낸사람</TH><TH>메시지</TH><TH>전송시간</TH><TH>수정</TH><TH>삭제</TH>";
   echo "</TR>";
   
   while($row = mysqli_fetch_array($ret)) {
      echo "<TR>";
      echo "<TD>", $row['message_id'], "</TD>";
      echo "<TD>", $row['title'], "</TD>";
      echo "<TD>", $row['username'], "</TD>";
      echo "<TD>", $row['message_text'], "</TD>";
      echo "<TD>", $row['sent_at'], "</TD>";
      echo "<TD>", "<a href='chat_update.php?message_id=", $row['message_id'], "'>수정</a></TD>";
      echo "<TD>", "<a href='chat_delete.php?message_id=", $row['message_id'], "'>삭제</a></TD>";
      echo "</TR>";	  
   }   
   mysqli_close($con);
   echo "</TABLE>"; 
   echo "<br> <a href='admin_main.html'> <--관리자 메인</a> ";
?>