<?php
   include '../dbconn.php';
   
   $item_id = $_GET['item_id'];

   // 상품 상세 정보 가져오기
   $sql = "SELECT i.*, u.username, u.region, c.name as category_name 
           FROM Items i 
           JOIN Users u ON i.seller_id = u.user_id 
           JOIN Categories c ON i.category_id = c.category_id
           WHERE i.item_id = '".$item_id."'";
 
   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
       if ($count == 0) {
           echo $item_id." 아이디의 상품이 없음!!!"."<br>";
           echo "<br> <a href='item_list.php'> <--상품 목록으로 돌아가기</a> ";
           exit();	
       }
   }
   else {
       echo "Items 데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       exit();
   } 
   
   $row = mysqli_fetch_array($ret);
   $title = $row['title'];
   $price = $row['price'];
   $username = $row['username'];
   $region = $row['region'];
   $category_name = $row['category_name'];
   $status = $row['status'];
   $posted_at = $row['posted_at'];
   $seller_id = $row['seller_id'];
   
   // 해당 상품의 채팅 가져오기
   $sql_chats = "SELECT c.*, u.username 
                 FROM ChatMessages c 
                 JOIN Users u ON c.sender_id = u.user_id 
                 WHERE c.item_id = '".$item_id."'
                 ORDER BY c.sent_at";
   $chat_result = mysqli_query($con, $sql_chats);
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 상품 상세</TITLE>
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
    .item-detail {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .item-price {
        color: #FF8A3D;
        font-weight: bold;
        font-size: 24px;
        margin: 15px 0;
    }
    .item-meta {
        margin-bottom: 15px;
    }
    .item-status {
        display: inline-block;
        padding: 5px 10px;
        background-color: #FF8A3D;
        color: white;
        border-radius: 5px;
        margin-right: 10px;
    }
    .item-seller {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .chats-section {
        margin-top: 30px;
    }
    .chat-message {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
    }
    .chat-sender {
        font-weight: bold;
        margin-bottom: 5px;
    }
    .chat-time {
        color: #666;
        font-size: 12px;
    }
    .back-link {
        display: block;
        margin-top: 20px;
    }
</style>
</HEAD>
<BODY>

<h1><?php echo $title; ?></h1>

<div class="item-detail">
    <div class="item-price"><?php echo number_format($price); ?>원</div>
    
    <div class="item-meta">
        <span class="item-status"><?php echo $status; ?></span>
        <span>카테고리: <?php echo $category_name; ?></span>
    </div>
    
    <div class="item-seller">
        <div>
            <div>판매자: <?php echo $username; ?></div>
            <div>지역: <?php echo $region; ?></div>
            <div>등록일: <?php echo $posted_at; ?></div>
        </div>
    </div>
    
    <a href="chat.php?item_id=<?php echo $item_id; ?>">채팅으로 거래하기</a>
</div>

<div class="chats-section">
    <h2>상품 문의</h2>
    <?php
        if(mysqli_num_rows($chat_result) > 0) {
            while($chat = mysqli_fetch_array($chat_result)) {
                echo "<div class='chat-message'>";
                echo "<div class='chat-sender'>".$chat['username']."</div>";
                echo "<div>".$chat['message_text']."</div>";
                echo "<div class='chat-time'>".$chat['sent_at']."</div>";
                echo "</div>";
            }
        } else {
            echo "<p>아직 문의가 없습니다.</p>";
        }
    ?>
</div>

<a href='item_list.php' class="back-link"> <-- 상품 목록으로 돌아가기</a>

</BODY>
</HTML>
<?php
   mysqli_close($con);
?>