<?php
   include '../dbconn.php';
   $sql = "SELECT * FROM Categories WHERE category_id='".$_GET['category_id']."'";

   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
       if ($count == 0) {
           echo $_GET['category_id']." 아이디의 카테고리가 없음!!!"."<br>";
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
   $category_id = $row['category_id'];
   $name = $row["name"];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 카테고리 삭제</TITLE>
</HEAD>
<BODY>

<h1> 카테고리 삭제 </h1>
<FORM METHOD="post" ACTION="category_delete_result.php">
    카테고리 ID: <INPUT TYPE="text" NAME="category_id" VALUE=<?php echo $category_id ?> READONLY> <br>
    카테고리명: <INPUT TYPE="text" NAME="name" VALUE=<?php echo $name ?> READONLY> <br> 
    <BR><BR>
    위 카테고리를 삭제하겠습니까?	
    <INPUT TYPE="submit" VALUE="카테고리 삭제">
</FORM>

<br>
<a href='admin_main.html'> <--관리자 메인</a>

</BODY>
</HTML>