<?php
   include '../dbconn.php';
   $sql = "SELECT c.*, i.title, u.username 
           FROM ChatMessages c 
           JOIN Items i ON c.item_id = i.item_id 
           JOIN Users u ON c.sender_id = u.user_id 
           WHERE c.message_id='".$_GET['message_id']."'";

   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
       if ($count == 0) {
           echo $_GET['message_id']." 아이디의 채팅이 없음!!!"."<br>";
           echo "<br> <a href='admin_main.html'> <--관리자 메인</a> ";
           exit();	
       }		   
   }
   else {
       echo "데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       echo "<br> <a href='admin_main.html'> <--관리자 메인</a> ";
       exit();
   }   
   $row = mysqli_fetch_array($ret);
   $message_id = $row['message_id'];
   $title = $row["title"];
   $username = $row["username"];
   $message_text = $row["message_text"];
   $sent_at = $row["sent_at"];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 채팅 삭제</TITLE>
</HEAD>
<BODY>

<h1> 채팅 삭제 </h1>
<FORM METHOD="post" ACTION="chat_delete_result.php">
    메시지 ID: <INPUT TYPE="text" NAME="message_id" VALUE=<?php echo $message_id ?> READONLY> <br>
    상품: <INPUT TYPE="text" NAME="title" VALUE="<?php echo $title ?>" READONLY> <br> 
    보낸사람: <INPUT TYPE="text" NAME="username" VALUE="<?php echo $username ?>" READONLY> <br>
    메시지: <textarea name="message_text" rows="4" cols="50" readonly><?php echo $message_text ?></textarea><br>
    전송시간: <INPUT TYPE="text" NAME="sent_at" VALUE="<?php echo $sent_at ?>" READONLY> <br>
    <BR><BR>
    위 채팅을 삭제하겠습니까?	
    <INPUT TYPE="submit" VALUE="채팅 삭제">
</FORM>

<br>
<a href='admin_main.html'> <--관리자 메인</a>

</BODY>
</HTML>