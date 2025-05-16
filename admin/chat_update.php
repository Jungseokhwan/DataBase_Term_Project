<?php
   include '../dbconn.php';
   $sql = "SELECT * FROM ChatMessages WHERE message_id='".$_GET['message_id']."'";

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
   $item_id = $row["item_id"];
   $sender_id = $row["sender_id"];
   $message_text = $row["message_text"];
   $sent_at = $row["sent_at"];
   
   // 상품 목록 가져오기
   $sql_items = "SELECT * FROM Items";
   $result_items = mysqli_query($con, $sql_items);
   
   // 사용자 목록 가져오기
   $sql_users = "SELECT * FROM Users";
   $result_users = mysqli_query($con, $sql_users);
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 채팅 수정</TITLE>
</HEAD>
<BODY>

<h1> 채팅 정보 수정 </h1>
<FORM METHOD="post" ACTION="chat_update_result.php">
    메시지 ID: <INPUT TYPE="text" NAME="message_id" VALUE=<?php echo $message_id ?> READONLY> <br>
    
    상품: 
    <select name="item_id">
        <?php
            while($item = mysqli_fetch_array($result_items)) {
                if($item['item_id'] == $item_id) {
                    echo "<option value='".$item['item_id']."' selected>".$item['title']."</option>";
                } else {
                    echo "<option value='".$item['item_id']."'>".$item['title']."</option>";
                }
            }
        ?>
    </select><br>
    
    보낸사람: 
    <select name="sender_id">
        <?php
            while($user = mysqli_fetch_array($result_users)) {
                if($user['user_id'] == $sender_id) {
                    echo "<option value='".$user['user_id']."' selected>".$user['username']."</option>";
                } else {
                    echo "<option value='".$user['user_id']."'>".$user['username']."</option>";
                }
            }
        ?>
    </select><br>
    
    메시지: <textarea name="message_text" rows="4" cols="50"><?php echo $message_text ?></textarea><br>
    전송시간: <INPUT TYPE="text" NAME="sent_at" VALUE="<?php echo $sent_at ?>" READONLY> <br>
    <BR><BR>
    <INPUT TYPE="submit" VALUE="정보 수정">
</FORM>

<br>
<a href='admin_main.html'> <--관리자 메인</a>

</BODY>
</HTML>