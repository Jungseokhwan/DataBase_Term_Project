<?php
   include '../dbconn.php';
   
   // 사용자 목록 가져오기
   $sql_users = "SELECT * FROM Users";
   $result_users = mysqli_query($con, $sql_users);
   
   // 카테고리 목록 가져오기
   $sql_categories = "SELECT * FROM Categories";
   $result_categories = mysqli_query($con, $sql_categories);
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 상품 추가</TITLE>
</HEAD>
<BODY>

<h1> 신규 상품 입력 </h1>
<FORM METHOD="post" ACTION="item_insert_result.php">
    판매자: 
    <select name="seller_id">
        <?php
            while($row = mysqli_fetch_array($result_users)) {
                echo "<option value='".$row['user_id']."'>".$row['username']."</option>";
            }
        ?>
    </select><br>
    
    카테고리: 
    <select name="category_id">
        <?php
            while($row = mysqli_fetch_array($result_categories)) {
                echo "<option value='".$row['category_id']."'>".$row['name']."</option>";
            }
        ?>
    </select><br>
    
    제목: <INPUT TYPE="text" NAME="title"> <br>
    가격: <INPUT TYPE="number" NAME="price"> <br>
    상태: 
    <select name="status">
        <option value="available">판매중</option>
        <option value="sold">판매완료</option>
        <option value="reserved">예약중</option>
    </select><br>
    <BR><BR>
    <INPUT TYPE="submit" VALUE="상품 입력">
</FORM>

<br>
<a href='admin_main.html'> <--관리자 메인</a>

</BODY>
</HTML>
<?php
   mysqli_close($con);
?>