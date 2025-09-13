<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/db.php");
    $id = $_GET["id"];
    if($_GET["check"]) {
        $result = $conn->query("select views from dogs where id = $id");
        $row = $result->fetch_assoc();
        $views = $row['views'] + 1;
        $stmt = $conn->prepare("UPDATE dogs SET views = ? where id = ?");
        $stmt->bind_param("ss", $views, $id);
        $stmt->execute();
    }
    $sql = query("select * from dogs where id = $id");
    $dogs = $sql->fetch_array();
    $user_idx = $_SESSION["user_idx"];
    $liked = false;
    $result = $conn->query("select * from user_likes_dogs where user_id ='$user_idx' and dog_id = '$id'");
    if ($result && $result->num_rows > 0) {
        $liked = true;
    }
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/includes/head.php");
?>

    <main>
        <div class="details">
            <div class="title">
                <h1><?php echo $dogs["name"] ?></h1>
                <h3> <?php echo "조회수 : ".$dogs["views"]."회"?> </h3>
                <button class="like"> 
                     <img src="<?php echo "/DogsDictionary/assets/images/".($liked ? 'likeTrue.png' : 'likeFalse.png') ?>" alt="like">
                </button>
            </div>
            <hr>
            <div class="content">
                <img src='<?php echo '/DogsDictionary'.$dogs['photo_url'];?>'> </img>
                <div class="explain">
                    <p> <?php echo "사는곳 : ".$dogs['live']?> </p>
                    <p> <?php echo "성격 : ".$dogs['pern']?></p>
                </div>
            </div>
        </div>
        <?php 
            $result = $conn->query("select r.reply_id,u.username, r.content, r.createdAt,r.user_id from users u, replys r where u.id = r.user_id and r.dog_id = $id");
        ?>
        <div class="replys">
            <h2>댓글 <?php echo $result->num_rows."개"?></h2>
            <div class="reply-list">
                <?php
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <div class="reply-item" data-reply-id="<?php echo $row['reply_id']; ?>">
                                <?php echo "<h2>".$row['username']."</h2>"; ?>
                                <?php echo "<h3>".$row['createdAt']."</h3>"; ?>
                                <?php echo "<div class='replyContent'>".$row['content']."</div>"; ?>
                                <?php if($_SESSION['user_idx'] == $row['user_id']) {?> 
                                    <div class="reply-actions">
                                        <button class="edit-btn">수정</button>
                                        <a href="/DogsDictionary/reply_delete.php?reply_id=<?php echo $row['reply_id']; ?>&dog_id=<?php echo $id; ?>">삭제</a>
                                    </div>
                                <?php } ?>
                            </div>
                <?php   } 
                    }
                ?>
                
            </div>
            <form action="/DogsDictionary/reply_add.php" method="POST">
                <input type="hidden" name="dog_id" value="<?php echo $id; ?>">
                <textarea name="content" rows="4" cols="50" placeholder="댓글을 입력하세요..." required></textarea>
                <br>
                <button type="submit">댓글 작성</button>
            </form>
        </div>
        
        
    </main>
    <script>
        // 수정 버튼
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const replyItem = btn.closest('.reply-item');
                    const replyId = replyItem.dataset.replyId;
                    const contentDiv = replyItem.querySelector('.replyContent');
                    const deleteLink = replyItem.querySelector('.reply-actions > a');
                    const originalContent = contentDiv.textContent;

                    const textarea = document.createElement('textarea');
                    textarea.value = originalContent;
                    textarea.rows = 3;
                    textarea.style.width = '100%';
                    
                    const actionsDiv = document.createElement('div');
                    const saveBtn = document.createElement('button');
                    saveBtn.textContent = '저장';
                    saveBtn.style.marginTop = '8px';

                    const cancelBtn = document.createElement('button');
                    cancelBtn.textContent = '취소';
                    cancelBtn.style.marginTop = '8px';

                    contentDiv.style.display = 'none';
                    btn.style.display = 'none';
                    deleteLink.style.display = 'none';

                    replyItem.appendChild(textarea);
                    actionsDiv.appendChild(saveBtn);
                    actionsDiv.appendChild(cancelBtn);
                    replyItem.appendChild(actionsDiv);

                    saveBtn.addEventListener('click', function() {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/DogsDictionary/reply_update.php';

                        const idInput = document.createElement('input');
                        idInput.type = 'hidden';
                        idInput.name = 'reply_id';
                        idInput.value = replyId;

                        const contentInput = document.createElement('input');
                        contentInput.type = 'hidden';
                        contentInput.name = 'content';
                        contentInput.value = textarea.value;

                        const dog_id = document.createElement('input');
                        dog_id.type = 'hidden';
                        dog_id.name = 'dog_id';
                        dog_id.value = '<?php echo $id; ?>';

                        form.appendChild(idInput);
                        form.appendChild(contentInput);
                        form.appendChild(dog_id);

                        document.body.appendChild(form);
                        form.submit();
                    });

                    cancelBtn.addEventListener('click', function() {
                        contentDiv.style.display = '';
                        btn.style.display = '';
                        deleteLink.style.display = '';
                        textarea.remove();
                        actionsDiv.remove();
                    });
                });
            });
        });



        document.addEventListener('DOMContentLoaded', () => {
            const likeBtn = document.querySelector('.like');
            const likeImg = likeBtn.querySelector('img');
            let liked = <?php echo $liked ? 'true' : 'false'; ?>;
            const userIdx = '<?php echo $user_idx; ?>';
            const dogId = '<?php echo $id; ?>';


            likeBtn.addEventListener('click', () => {
                liked = !liked;

                likeBtn.classList.add('active');
                setTimeout(() => likeBtn.classList.remove('active'), 200);
                likeImg.src = liked ? '/DogsDictionary/assets/images/likeTrue.png' : '/DogsDictionary/assets/images/likeFalse.png';
                fetch('/DogsDictionary/like_toggle.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `user_idx=${userIdx}&dog_id=${dogId}&liked=${liked}`
                });
            });
        });
    </script>


<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/includes/tail.php");
?>
