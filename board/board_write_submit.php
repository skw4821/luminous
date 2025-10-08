
<div class="container">
    <div class="messageHead">초 간단 게시판</div><br/>
    <div class="boardList">
        <section class="cart_header">
            <div class="delete_buttons">
                <button onclick="location.href='board_list.php'">글 목록</button>
                <button onclick="location.href='board_write.php'">글쓰기</button>
            </div>
        </section>
	</div>
</div>


<?php
	$host = "localhost";
	$passwd = "";
    $port = '3306';
    $dbName = 'exmall';
    $charset = 'utf8';
    $user = 'root';
@$oDB = new mysqli($host, $user, $passwd, $dbName);

if ($oDB->connect_error) {
    die("DB Error : ".$oDB->connect_error);
}

function sql_query($sql='') {
    global $oDB;

    return $oDB->query($sql);
}

function sql_get_row($sql='') {
    global $oDB;

    return $oDB->query($sql)->fetch_array(MYSQLI_ASSOC);
}

function sql_get_value($sql='') {
    global $oDB;

    return $oDB->query($sql)->fetch_array(MYSQLI_NUM)[0];
}


if (trim($_POST['b_title']) == "" || trim($_POST['b_contents']) == "") {
    die("<script>alert(\"제목과 내용을 입력해주세요.\"); history.back();</script>");
}


$sql = "insert into bd__board set
    b_title = '".$_POST['b_title']."',
    b_contents = '".$_POST['b_contents']."'
";

if (sql_query($sql)) {
    die("<script>alert(\"등록했습니다.\");</script>");
	header("Location: board_list.php");
} else {
    die("<script>alert(\"등록하지 못했습니다.\n\n서버 오류\"); history.back();</script>");
}
	header("Location: board_list.php");
?>

