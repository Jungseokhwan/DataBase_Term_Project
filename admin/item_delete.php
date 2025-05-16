<?php
   include '../dbconn.php';
   $sql = "SELECT i.*, u.username, c.name as category_name 
           FROM Items i 
           JOIN Users u ON i.seller_id = u.user_id 
           JOIN Categories c ON i.category_id = c.category_id 
           WHERE i.item_id='".$_GET['item_id']."'";

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
   $username = $row["username"];
   $category_name = $row["category_name"];
   $title = $row["title"];
   $price = $row["price"];
   $status = $row["status"];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 상품 삭제</TITLE>
</HEAD>
<BODY>

<h1> 상품 삭제 </h1>
<FORM METHOD="post" ACTION="item_delete_result.php">
    상품 ID: <INPUT TYPE="text" NAME="item_id" VALUE=<?php echo $item_id ?> READONLY> <br>
    판매자: <INPUT TYPE="text" NAME="username" VALUE="<?php echo $username ?>" READONLY> <br> 
    카테고리: <INPUT TYPE="text" NAME="category_name" VALUE="<?php echo $category_name ?>" READONLY> <br>
    제목: <INPUT TYPE="text" NAME="title" VALUE="<?php echo $title ?>" READONLY> <br>
    가격: <INPUT TYPE="text" NAME="price" VALUE=<?php echo $price ?> READONLY> <br>
    상태: <INPUT TYPE="text" NAME="status" VALUE=<?php echo $status ?> READONLY> <br>
    <BR><BR>
    위 상품을 삭제하겠습니까?	
    <INPUT TYPE="submit" VALUE="상품 삭제">
</FORM>

<br>
<a href='admin_main.html'> <--관리자 메인</a>

</BODY>
</HTML>