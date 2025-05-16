<?php
   include '../dbconn.php';

   // 필터링 조건 가져오기
   $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
   $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
   $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
   $date = isset($_GET['date']) ? $_GET['date'] : '';

   // 기본 쿼리
   $sql = "SELECT i.*, u.username, c.name as category_name 
           FROM Items i 
           JOIN Users u ON i.seller_id = u.user_id 
           JOIN Categories c ON i.category_id = c.category_id
           WHERE 1=1";
   
   // 조건 추가
   if($category_id != '') {
       $sql .= " AND i.category_id = '".$category_id."'";
   }
   
   if($min_price != '') {
       $sql .= " AND i.price >= '".$min_price."'";
   }
   
   if($max_price != '') {
       $sql .= " AND i.price <= '".$max_price."'";
   }
   
   if($date != '') {
       $sql .= " AND DATE(i.posted_at) = '".$date."'";
   }
   
   // 정렬
   $sql .= " ORDER BY i.posted_at DESC";
   
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
<TITLE>당근마켓 - 검색 결과</TITLE>
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
    .search-form {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    .search-form input, .search-form select {
        margin-bottom: 10px;
        padding: 5px;
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
    .search-result-header {
        margin: 20px 0;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }
    .back-link {
        display: block;
        margin-top: 20px;
    }
</style>
</HEAD>
<BODY>

<h1> 상품 검색 </h1>

<div class="search-form">
    <form method="get" action="search.php">
        카테고리: 
        <select name="category_id">
            <option value="">모든 카테고리</option>
            <?php
                $sql_categories = "SELECT * FROM Categories";
                $result_categories = mysqli_query($con, $sql_categories);
                while($row = mysqli_fetch_array($result_categories)) {
                    $selected = ($row['category_id'] == $category_id) ? 'selected' : '';
                    echo "<option value='".$row['category_id']."' ".$selected.">".$row['name']."</option>";
                }
            ?>
        </select><br>
        최소가격: <input type="number" name="min_price" value="<?php echo $min_price; ?>"><br>
        최대가격: <input type="number" name="max_price" value="<?php echo $max_price; ?>"><br>
        날짜: <input type="date" name="date" value="<?php echo $date; ?>"><br>
        <input type="submit" value="검색">
    </form>
</div>

<div class="search-result-header">
    검색 결과: <?php echo $count; ?>개의 상품이 검색되었습니다.
</div>

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