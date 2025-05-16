<?php
   // 임시로 사용자 아이디를 1로 고정 (실제로는 로그인 기능이 필요)
   $user_id = 1;
   
   include '../dbconn.php';
   $sql = "SELECT * FROM Items WHERE item_id='".$_GET['item_id']."' AND seller_id='".$user_id."'";

   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
       if ($count == 0) {
           echo $_GET['item_id']." 아이디의 상품이 없거나 수정 권한이 없습니다."."<br>";
           echo "<br> <a href='my_items.php'> <--내가 쓴 글로 돌아가기</a> ";
           exit();	
       }		   
   }
   else {
       echo "데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       echo "<br> <a href='my_items.php'> <--내가 쓴 글로 돌아가기</a> ";
       exit();
   }   
   $row = mysqli_fetch_array($ret);
   $item_id = $row['item_id'];
   $category_id = $row["category_id"];
   $title = $row["title"];
   $price = $row["price"];
   $status = $row["status"];
   
   // 카테고리 목록 가져오기
   $sql_categories = "SELECT * FROM Categories";
   $result_categories = mysqli_query($con, $sql_categories);
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 내 상품 수정</TITLE>
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
    input[type="text"], input[type="number"], select, textarea {
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

<h1> 상품 정보 수정 </h1>
<FORM METHOD="post" ACTION="my_item_update_result.php">
    <INPUT TYPE="hidden" NAME="item_id" VALUE=<?php echo $item_id ?>>
    <INPUT TYPE="hidden" NAME="seller_id" VALUE=<?php echo $user_id ?>>
    
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
    <BR><BR>
    <INPUT TYPE="submit" VALUE="정보 수정">
</FORM>

<a href='my_items.php' class="back-link"> <-- 내가 쓴 글로 돌아가기</a>

</BODY>
</HTML>