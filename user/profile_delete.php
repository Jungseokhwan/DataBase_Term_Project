<?php
   // 임시로 사용자 아이디를 1로 고정 (실제로는 로그인 기능이 필요)
   $user_id = 1;
   
   include '../dbconn.php';
   $sql = "SELECT * FROM Users WHERE user_id='".$user_id."'";

   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
       if ($count == 0) {
           echo $user_id." 아이디의 사용자가 없음!!!"."<br>";
           echo "<br> <a href='user_main.html'> <--사용자 메인</a> ";
           exit();	
       }		   
   }
   else {
       echo "데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       echo "<br> <a href='user_main.html'> <--사용자 메인</a> ";
       exit();
   }   
   $row = mysqli_fetch_array($ret);
   $username = $row["username"];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 회원 탈퇴</TITLE>
<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }
    h1 {
        color: #FF8A3D;
    }
    .alert-box {
        background-color: #ffeeee;
        border: 1px solid #ffaaaa;
        color: #cc0000;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    form {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
    }
    input[type="submit"] {
        background-color: #cc0000;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
    }
    .back-link {
        display: block;
        margin-top: 20px;
    }
</style>
</HEAD>
<BODY>

<h1> 회원 탈퇴 </h1>

<div class="alert-box">
    <strong>주의!</strong> 회원 탈퇴 시 모든 상품 정보와 채팅 내역이 삭제됩니다. 이 작업은 되돌릴 수 없습니다.
</div>

<FORM METHOD="post" ACTION="profile_delete_result.php">
    <INPUT TYPE="hidden" NAME="user_id" VALUE=<?php echo $user_id ?>>
    사용자명: <INPUT TYPE="text" NAME="username" VALUE=<?php echo $username ?> READONLY> <br>
    <BR><BR>
    정말 탈퇴하시겠습니까?	
    <INPUT TYPE="submit" VALUE="회원 탈퇴">
</FORM>

<a href='profile.php' class="back-link"> <-- 내 정보로 돌아가기</a>

</BODY>
</HTML>