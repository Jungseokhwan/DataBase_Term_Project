<?php
   include '../dbconn.php';
   $sql = "SELECT * FROM Users WHERE user_id='".$_GET['user_id']."'";

   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
       if ($count == 0) {
           echo $_GET['user_id']." 아이디의 사용자가 없음!!!"."<br>";
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
   $user_id = $row['user_id'];
   $username = $row["username"];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 사용자 삭제</TITLE>
</HEAD>
<BODY>

<h1> 사용자 삭제 </h1>
<FORM METHOD="post" ACTION="user_delete_result.php">
    ID: <INPUT TYPE="text" NAME="user_id" VALUE=<?php echo $user_id ?> READONLY> <br>
    사용자명: <INPUT TYPE="text" NAME="username" VALUE=<?php echo $username ?> READONLY> <br> 
    <BR><BR>
    위 사용자를 삭제하겠습니까?	
    <INPUT TYPE="submit" VALUE="사용자 삭제">
</FORM>

<br>
<a href='admin_main.html'> <--관리자 메인</a>

</BODY>
</HTML>