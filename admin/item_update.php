<?php
   include '../dbconn.php';
   $sql = "SELECT * FROM Items WHERE item_id='".$_GET['item_id']."'";

   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
       if ($count == 0) {
           echo $_GET['item_id']." 아이디의 상품이 없음!!!"."<br>";
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
   $item_id = $row['item_id'];
   $seller_id = $row["seller_id"];
   $category_id = $row["category_id"];
   $title = $row["title"];
   $price = $row["price"];
   $status = $row["status"];
   $posted_at = $row["posted_at"];
   
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
<TITLE>당근마켓 - 상품 수정</TITLE>
</HEAD>
<BODY>

<h1> 상품 정보 수정 </h1>
<FORM METHOD="post" ACTION="item_update_result.php">
    상품 ID: <INPUT TYPE="text" NAME="item_id" VALUE=<?php echo $item_id ?> READONLY> <br>
    
    판매자: 
    <select name="seller_id">
        <?php
            while($user = mysqli_fetch_array($result_users)) {
                if($user['user_id'] == $seller_id) {
                    echo "<option value='".$user['user_id']."' selected>".$user['username']."</option>";
                } else {
                    echo "<option value='".$user['user_id']."'>".$user['username']."</option>";
                }
            }
        ?>
    </select><br>
    
    카테고리: 
    <select name="category_id">
        <?php
            while($category = mysqli_fetch_array($result_categories)) {
                if($category['category_id'] == $category_id) {
                    echo "<option value='".$category['category_id']."' selected>".$category['name']."</option>";
                } else {
                    echo "<option value='".$category['category_id']."'>".$category['name']."</option>";
                }
            }
        ?>
    </select><br>
    
    제목: <INPUT TYPE="text" NAME="title" VALUE="<?php echo $title ?>"> <br>
    가격: <INPUT TYPE="number" NAME="price" VALUE=<?php echo $price ?>> <br>
    상태: 
    <select name="status">
        <option value="available" <?php if($status == 'available') echo 'selected'; ?>>판매중</option>
        <option value="sold" <?php if($status == 'sold') echo 'selected'; ?>>판매완료</option>
        <option value="reserved" <?php if($status == 'reserved') echo 'selected'; ?>>예약중</option>
    </select><br>
    등록일: <INPUT TYPE="text" NAME="posted_at" VALUE="<?php echo $posted_at ?>" READONLY> <br>
    <BR><BR>
    <INPUT TYPE="submit" VALUE="정보 수정">
</FORM>

<br>
<a href='admin_main.html'> <--관리자 메인</a>

</BODY>
</HTML>