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
   $region = $row["region"];
   $created_at = $row["created_at"];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 내 정보 수정</TITLE>
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
    form {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
    }
    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    input[type="submit"] {
        background-color: #FF8A3D;
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

<h1> 내 정보 수정 </h1>
<FORM METHOD="post" ACTION="profile_update_result.php">
    <INPUT TYPE="hidden" NAME="user_id" VALUE=<?php echo $user_id ?>>
    사용자명: <INPUT TYPE="text" NAME="username" VALUE=<?php echo $username ?>> <br> 
    지역: <INPUT TYPE="text" NAME="region" VALUE=<?php echo $region ?>> <br>
    가입일: <INPUT TYPE="text" NAME="created_at" VALUE="<?php echo $created_at ?>" READONLY> <br>
    <BR><BR>
    <INPUT TYPE="submit" VALUE="정보 수정">
</FORM>

<a href='profile.php' class="back-link"> <-- 내 정보로 돌아가기</a>

</BODY>
</HTML>