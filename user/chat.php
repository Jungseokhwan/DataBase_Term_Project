<?php
   // 임시로 사용자 아이디를 1로 고정 (실제로는 로그인 기능이 필요)
   $user_id = 1;
   
   include '../dbconn.php';

   // 상품 ID가 넘어왔는지 확인
   $item_id = isset($_GET['item_id']) ? $_GET['item_id'] : '';
   
   if($item_id) {
       // 특정 상품의 채팅 가져오기
       $sql = "SELECT c.*, i.title, u.username 
               FROM ChatMessages c 
               JOIN Items i ON c.item_id = i.item_id 
               JOIN Users u ON c.sender_id = u.user_id 
               WHERE c.item_id = '".$item_id."'
               ORDER BY c.sent_at";
       
       // 상품 정보 가져오기
       $sql_item = "SELECT i.*, u.username, c.name as category_name 
                    FROM Items i 
                    JOIN Users u ON i.seller_id = u.user_id 
                    JOIN Categories c ON i.category_id = c.category_id 
                    WHERE i.item_id = '".$item_id."'";
       $ret_item = mysqli_query($con, $sql_item);
       $item = mysqli_fetch_array($ret_item);
   } else {
       // 사용자의 모든 채팅 가져오기 (보낸 메시지 + 자신의 상품에 대한 메시지)
       $sql = "SELECT c.*, i.title, u.username 
               FROM ChatMessages c 
               JOIN Items i ON c.item_id = i.item_id 
               JOIN Users u ON c.sender_id = u.user_id 
               WHERE c.sender_id = '".$user_id."' OR i.seller_id = '".$user_id."'
               ORDER BY c.sent_at DESC";
   }
 
   $ret = mysqli_query($con, $sql);   
   if($ret) {
       $count = mysqli_num_rows($ret);
   }
   else {
       echo "ChatMessages 데이터 검색 실패!!!"."<br>";
       echo "실패 원인 :".mysqli_error($con);
       exit();
   } 
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<TITLE>당근마켓 - 채팅</TITLE>
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
    .item-info {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    .item-title {
        font-weight: bold;
        font-size: 18px;
    }
    .item-price {
        color: #FF8A3D;
        font-weight: bold;
        margin-left: 20px;
    }
    .chat-container {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .chat-message {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 8px;
    }
    .message-mine {
        background-color: #FFF3E0;
        margin-left: 20%;
    }
    .message-other {
        background-color: #F5F5F5;
        margin-right: 20%;
    }
    .message-sender {
        font-weight: bold;
        margin-bottom: 5px;
    }
    .message-time {
        font-size: 12px;
        color: #666;
        text-align: right;
    }
    .message-form {
        margin-top: 20px;
        display: flex;
    }
    .message-input {
        flex-grow: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .message-submit {
        margin-left: 10px;
        padding: 10px 15px;
        background-color: #FF8A3D;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .chat-list-item {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
    }
    .chat-list-title {
        font-weight: bold;
        margin-bottom: 5px;
    }
    .chat-list-preview {
        color: #666;
        font-size: 14px;
    }
    .back-link {
        display: block;
        margin-top: 20px;
    }
</style>
</HEAD>
<BODY>

<?php if($item_id): ?>
    <!-- 특정 상품의 채팅 화면 -->
    <h1>채팅</h1>
    
    <div class="item-info">
        <div class="item-title"><?php echo $item['title']; ?></div>
        <div class="item-price"><?php echo number_format($item['price']); ?>원</div>
    </div>
    
    <div class="chat-container">
        <?php
            if($count > 0) {
                while($row = mysqli_fetch_array($ret)) {
                    $message_class = ($row['sender_id'] == $user_id) ? 'message-mine' : 'message-other';
                    echo "<div class='chat-message ".$message_class."'>";
                    echo "<div class='message-sender'>".$row['username']."</div>";
                    echo "<div class='message-content'>".$row['message_text']."</div>";
                    echo "<div class='message-time'>".$row['sent_at']."</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>아직 채팅 내역이 없습니다.</p>";
            }
        ?>
    </div>
    
    <form class="message-form" method="post" action="chat_send.php">
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
        <input type="hidden" name="sender_id" value="<?php echo $user_id; ?>">
        <input type="text" name="message_text" class="message-input" placeholder="메시지를 입력하세요" required>
        <input type="submit" value="전송" class="message-submit">
    </form>
    
    <a href='item_detail.php?item_id=<?php echo $item_id; ?>' class="back-link"> <-- 상품 페이지로 돌아가기</a>
<?php else: ?>
    <!-- 채팅 목록 화면 -->
    <h1>채팅 목록</h1>
    
    <?php
        if($count > 0) {
            // 채팅이 있는 상품 ID 목록 (중복 제거)
            $item_ids = array();
            $chats_by_item = array();
            
            // 채팅을 상품별로 그룹화
            while($row = mysqli_fetch_array($ret)) {
                if(!in_array($row['item_id'], $item_ids)) {
                    $item_ids[] = $row['item_id'];
                }
                $chats_by_item[$row['item_id']][] = $row;
            }
            
            // 각 상품별 최신 채팅 표시
            foreach($item_ids as $id) {
                $latest = end($chats_by_item[$id]);
                echo "<a href='chat.php?item_id=".$id."'>";
                echo "<div class='chat-list-item'>";
                echo "<div class='chat-list-title'>".$latest['title']."</div>";
                echo "<div class='chat-list-preview'>";
                echo "<strong>".$latest['username'].":</strong> ".$latest['message_text'];
                echo "</div>";
                echo "<div class='message-time'>".$latest['sent_at']."</div>";
                echo "</div>";
                echo "</a>";
            }
        } else {
            echo "<p>채팅 내역이 없습니다.</p>";
        }
    ?>
    
    <a href='user_main.html' class="back-link"> <-- 사용자 메인으로 돌아가기</a>
<?php endif; ?>

</BODY>
</HTML>
<?php
   mysqli_close($con);
?>