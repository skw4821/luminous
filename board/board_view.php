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
?>
<style>
.container {
    width:1080px;
    padding:10px;
    margin: 0px auto;
}

.messageHead {
    border:3px #cccccc solid;
    padding:5px;
    font-size:10pt;
    text-align:center;
}
</style>
<div class="container">
    <div class="messageHead">초 간단 게시판</div><br/>
    <div class="boardList">
        <section class="cart_header">
            <div class="delete_buttons">
                <button onclick="location.href='board_list.php'">글 목록</button>
                <button onclick="location.href='board_write.php'">글쓰기</button>
            </div>
        </section>
<?php
if ($_GET['b_idx'] == "") {
    die("표시할 글이 없습니다.");
}


$board_data = sql_get_row("select * from bd__board where b_idx = '".addslashes($_GET['b_idx'])."'");

if (!$board_data['b_idx']) {
    die("존재하지 않는 글입니다.");
}
?>
<div class="container">
    <h3><?=$board_data['b_title']?></h3><hr/>
    <p><?=$board_data['b_contents']?></p>
</div>