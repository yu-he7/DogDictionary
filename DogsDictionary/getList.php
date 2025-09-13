<main>
<div class="List">  
    <table>
        <tr>
            <th>No</th>
            <th>사진</th>
            <th>강아지종</th>
            <th>조회수</th>
            <th width="180px">옵션</th>
        </tr>
<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/db.php");
    $tmp = isset($_GET["sql"]) ? $_GET["sql"] : ''; 
    $fileName = isset($_GET["fileName"]) ? $_GET["fileName"] : '';
    $result = $conn->query($tmp);
    $num = $result->num_rows;
    // 페이지 네이션
    $list_num = 5;
    $page_num = 5;
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $total_page = ceil($num / $list_num);
    $total_block = ceil($total_page / $page_num);
    $now_block = ceil($page / $page_num);
    $s_pageNum = ($now_block - 1) * $page_num + 1;
    if($s_pageNum <= 0) {
        $s_pageNum = 1;
    };
    $No = $num - ($page - 1) * $list_num;


    $e_pageNum = $now_block * $page_num;

    if($e_pageNum > $total_page) {
        $e_pageNum = $total_page;
    }

    $start = ($page - 1) * $list_num;
    $sql = query("$tmp limit $start, $list_num");
    while($dogs = $sql->fetch_array()) {
        $url = '/DogsDictionary'.$dogs['photo_url'];
        $check = true;
?>
        <tr>
            <td> <?php echo  $No--;?></td>
            <td> <?php echo "<img src='$url' alt='photos'>" ?> </td>
            <td> <?php echo $dogs['name'] ?> </td>
            <td> <?php echo $dogs['views']."회" ?> </td>
            <td class="options">  <a href="./detail.php?id=<?php echo $dogs["id"] ?>&check=true">더 알아보기</a></td>
        </tr>
        
<?php } ?>
    </table>
</div>
    <div class="paging">
      <p class="pager">
        <a href="/DogsDictionary/<?php echo $fileName?>.php?page=1">&lt&lt</a>
        <?php
        if ($page <= 1) {
        ?>
          <a href="/DogsDictionary/<?php echo $fileName?>.php?page=1">이전</a>
        <?php } else { ?>
          <a href="/DogsDictionary/<?php echo $fileName?>.php?page=<?php echo ($page - 1); ?>">이전</a>
        <?php }; ?>

        <?php
        for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) {
        ?>
          <a href="/DogsDictionary/<?php echo $fileName?>.php?page=<?php echo $print_page; ?>"><?php echo $print_page; ?></a>
        <?php }; ?>

        <?php
        if ($page >= $total_page) {
        ?>
          <a href="/DogsDictionary/<?php echo $fileName?>.php?page=<?php echo $total_page; ?>">다음</a>
        <?php } else { ?>
          <a href="/DogsDictionary/<?php echo $fileName?>.php?page=<?php echo ($page + 1); ?>">다음</a>
        <?php }; ?>
        <a href="/DogsDictionary/<?php echo $fileName?>.php?page=<?php echo $total_page; ?>">&gt&gt</a>
      </p>
    </div>
</main>
