<?php
   include '../dbconn.php';

   // 카테고리 목록 가져오기
   $sql = "SELECT c.*, COUNT(i.item_id) as item_count 
           FROM Categories c 
           LEFT JOIN Items i ON c.category_id = i.category_id 
           GROUP BY c.category_id";
 
   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
   }
   else {
       echo "Categories 데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       exit();
   } 
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 카테고리 목록</TITLE>
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
    .category-list {
        margin-top: 20px;
    }
    .category-item {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .category-name {
        font-weight: bold;
    }
    .category-count {
        background-color: #FF8A3D;
        color: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .back-link {
        display: block;
        margin-top: 20px;
    }
</style>
</HEAD>
<BODY>

<h1> 카테고리 목록 </h1>

<div class="category-list">
<?php
    while($row = mysqli_fetch_array($ret)) {
        echo "<a href='search.php?category_id=".$row['category_id']."'>";
        echo "<div class='category-item'>";
        echo "<span class='category-name'>".$row['name']."</span>";
        echo "<span class='category-count'>".$row['item_count']."</span>";
        echo "</div>";
        echo "</a>";
    }
?>
</div>

<a href='user_main.html' class="back-link"> <-- 사용자 메인으로 돌아가기</a>

</BODY>
</HTML>
<?php
   mysqli_close($con);
?>