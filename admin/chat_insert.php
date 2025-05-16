<?php
   include '../dbconn.php';
   
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
<TITLE>당근마켓 - 채팅 추가</TITLE>
</HEAD>
<BODY>

<h1> 신규 채팅 입력 </h1>
<FORM METHOD="post" ACTION="chat_insert_result.php">
    상품: 
    <select name="item_id">
        <?php
            while($row = mysqli_fetch_array($result_items)) {
                echo "<option value='".$row['item_id']."'>".$row['title']."</option>";
            }
        ?>
    </select><br>
    
    보낸사람: 
    <select name="sender_id">
        <?php
            while($row = mysqli_fetch_array($result_users)) {
                echo "<option value='".$row['user_id']."'>".$row['username']."</option>";
            }
        ?>
    </select><br>
    
    메시지: <textarea name="message_text" rows="4" cols="50"></textarea><br>
    <BR><BR>
    <INPUT TYPE="submit" VALUE="채팅 입력">
</FORM>

<br>
<a href='admin_main.html'> <--관리자 메인</a>

</BODY>
</HTML>
<?php
   mysqli_close($con);
?>