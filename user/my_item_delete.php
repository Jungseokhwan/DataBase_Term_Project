<?php
   // 임시로 사용자 아이디를 1로 고정 (실제로는 로그인 기능이 필요)
   $user_id = 1;
   
   include '../dbconn.php';
   $sql = "SELECT i.*, c.name as category_name 
           FROM Items i 
           JOIN Categories c ON i.category_id = c.category_id 
           WHERE i.item_id='".$_GET['item_id']."' AND i.seller_id='".$user_id."'";

   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
       if ($count == 0) {
           echo $_GET['item_id']." 아이디의 상품이 없거나 삭제 권한이 없습니다."."<br>";
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
   $title = $row["title"];
   $category_name = $row["category_name"];
   $price = $row["price"];
   $status = $row["status"];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 상품 삭제</TITLE>
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
    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
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

<h1> 상품 삭제 </h1>

<div class="alert-box">
    <strong>주의!</strong> 상품 삭제 시 관련된 모든 채팅 내역이 삭제됩니다. 이 작업은 되돌릴 수 없습니다.
</div>

<FORM METHOD="post" ACTION="my_item_delete_result.php">
    <INPUT TYPE="hidden" NAME="item_id" VALUE=<?php echo $item_id ?>>
    <INPUT TYPE="hidden" NAME="seller_id" VALUE=<?php echo $user_id ?>>
    
    제목: <INPUT TYPE="text" NAME="title" VALUE="<?php echo $title ?>" READONLY> <br>
    카테고리: <INPUT TYPE="text" NAME="category_name" VALUE="<?php echo $category_name ?>" READONLY> <br>
    가격: <INPUT TYPE="text" NAME="price" VALUE="<?php echo number_format($price) ?>원" READONLY> <br>
    상태: <INPUT TYPE="text" NAME="status" VALUE="<?php echo $status ?>" READONLY> <br>
    <BR>
    정말 삭제하시겠습니까?	
    <INPUT TYPE="submit" VALUE="상품 삭제">
</FORM>

<a href='my_items.php' class="back-link"> <-- 내가 쓴 글로 돌아가기</a>

</BODY>
</HTML>