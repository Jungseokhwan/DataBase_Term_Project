<?php
   // 임시로 사용자 아이디를 1로 고정 (실제로는 로그인 기능이 필요)
   $user_id = 1;
   
   include '../dbconn.php';

   // 사용자 정보 가져오기
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
   $user = mysqli_fetch_array($ret);
   
   // 사용자의 상품 개수 가져오기
   $sql_items = "SELECT COUNT(*) as item_count FROM Items WHERE seller_id='".$user_id."'";
   $ret_items = mysqli_query($con, $sql_items);
   $row_items = mysqli_fetch_array($ret_items);
   $item_count = $row_items['item_count'];
   
   // 사용자의 채팅 개수 가져오기
   $sql_chats = "SELECT COUNT(*) as chat_count FROM ChatMessages WHERE sender_id='".$user_id."'";
   $ret_chats = mysqli_query($con, $sql_chats);
   $row_chats = mysqli_fetch_array($ret_chats);
   $chat_count = $row_chats['chat_count'];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 내 정보</TITLE>
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
    .profile-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .profile-info {
        margin-bottom: 20px;
    }
    .profile-stat {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .button {
        display: inline-block;
        background-color: #FF8A3D;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        margin-right: 10px;
    }
    .back-link {
        display: block;
        margin-top: 20px;
    }
</style>
</HEAD>
<BODY>

<h1> 내 정보 </h1>

<div class="profile-card">
    <div class="profile-info">
        <h2><?php echo $user['username']; ?></h2>
        <p>지역: <?php echo $user['region']; ?></p>
        <p>가입일: <?php echo $user['created_at']; ?></p>
    </div>
    
    <div class="profile-stats">
        <div class="profile-stat">
            <span>판매 상품 수</span>
            <span><?php echo $item_count; ?>개</span>
        </div>
        <div class="profile-stat">
            <span>채팅 수</span>
            <span><?php echo $chat_count; ?>개</span>
        </div>
    </div>
    
    <div class="profile-actions">
        <a href="profile_update.php" class="button">정보 수정</a>
        <a href="profile_delete.php" class="button">회원 탈퇴</a>
    </div>
</div>

<a href='user_main.html' class="back-link"> <-- 사용자 메인으로 돌아가기</a>

</BODY>
</HTML>
<?php
   mysqli_close($con);
?>