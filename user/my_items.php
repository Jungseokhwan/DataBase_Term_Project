<?php
   // 임시로 사용자 아이디를 1로 고정 (실제로는 로그인 기능이 필요)
   $user_id = 1;
   
   include '../dbconn.php';

   // 자신이 등록한 상품 목록 가져오기
   $sql = "SELECT i.*, c.name as category_name 
           FROM Items i 
           JOIN Categories c ON i.category_id = c.category_id
           WHERE i.seller_id = '".$user_id."'
           ORDER BY i.posted_at DESC";
 
   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
   }
   else {
       echo "Items 데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       exit();
   } 
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 내가 쓴 글</TITLE>
<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    h1 {
        color: #FF8A3D;
    }
    .item-list {
        margin-top: 20px;
    }
    .item-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .item-info {
        flex: 1;
    }
    .item-title {
        font-weight: bold;
        margin-bottom: 5px;
    }
    .item-price {
        color: #FF8A3D;
        font-weight: bold;
    }
    .item-meta {
        color: #666;
        font-size: 14px;
        margin-top: 5px;
    }
    .item-actions {
        display: flex;
    }
    .action-button {
        margin-left: 10px;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        color: white;
    }
    .edit-button {
        background-color: #4CAF50;
    }
    .delete-button {
        background-color: #F44336;
    }
    .back-link {
        display: block;
        margin-top: 20px;
    }
</style>
</HEAD>
<BODY>

<h1> 내가 쓴 글 </h1>

<div class="item-list">
    <?php
        if($count > 0) {
            while($row = mysqli_fetch_array($ret)) {
                echo "<div class='item-card'>";
                echo "<div class='item-info'>";
                echo "<div class='item-title'>".$row['title']."</div>";
                echo "<div class='item-price'>".number_format($row['price'])."원</div>";
                echo "<div class='item-meta'>";
                echo "카테고리: ".$row['category_name']." | ";
                echo "상태: ".$row['status']." | ";
                echo "등록일: ".$row['posted_at'];
                echo "</div>";
                echo "</div>";
                echo "<div class='item-actions'>";
                echo "<a href='my_item_update.php?item_id=".$row['item_id']."' class='action-button edit-button'>수정</a>";
                echo "<a href='my_item_delete.php?item_id=".$row['item_id']."' class='action-button delete-button'>삭제</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>등록한 상품이 없습니다.</p>";
        }
    ?>
</div>

<a href='user_main.html' class="back-link"> <-- 사용자 메인으로 돌아가기</a>

</BODY>
</HTML>
<?php
   mysqli_close($con);
?>