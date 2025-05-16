<?php
   include '../dbconn.php';

   // 상품 목록 가져오기
   $sql = "SELECT i.*, u.username, c.name as category_name 
           FROM Items i 
           JOIN Users u ON i.seller_id = u.user_id 
           JOIN Categories c ON i.category_id = c.category_id
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
<TITLE>당근마켓 - 상품 목록</TITLE>
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
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .item-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .item-title {
        font-weight: bold;
        margin-bottom: 10px;
    }
    .item-price {
        color: #FF8A3D;
        font-weight: bold;
        font-size: 18px;
    }
    .item-meta {
        color: #666;
        font-size: 14px;
        margin-top: 10px;
    }
    .back-link {
        display: block;
        margin-top: 20px;
    }
</style>
</HEAD>
<BODY>

<h1> 당근마켓 상품 목록 </h1>

<div class="item-list">
<?php
    while($row = mysqli_fetch_array($ret)) {
        echo "<div class='item-card'>";
        echo "<div class='item-title'><a href='item_detail.php?item_id=".$row['item_id']."'>".$row['title']."</a></div>";
        echo "<div class='item-price'>".number_format($row['price'])."원</div>";
        echo "<div class='item-meta'>";
        echo "판매자: ".$row['username']." | ";
        echo "카테고리: ".$row['category_name']." | ";
        echo "상태: ".$row['status']."<br>";
        echo "등록일: ".$row['posted_at'];
        echo "</div>";
        echo "</div>";
    }
?>
</div>

<a href='user_main.html' class="back-link"> <-- 사용자 메인으로 돌아가기</a>

</BODY>
</HTML>
<?php
   mysqli_close($con);
?>