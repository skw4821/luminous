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
<div class="container">
    <div class="messageHead">게시판 작성..</div><br/>
    <div class="boardList">
        <section class="cart_header">
            <div class="delete_buttons">
                <button onclick="location.href='board_list.php'">글 목록</button>
                <button onclick="location.href='board_write.php'">글쓰기</button>
            </div>
        </section>
    <form method="post" name="dispBoardWriteForm" id="dispBoardWriteForm" action="./board_write_submit.php" onsubmit="return procFilter('dispBoardWriteFormSubmit')" style="font-size:10pt">
        제 목<br/>
        <input type="text" name="b_title" id="b_title" placeholder="제목을 입력하세요." style="width:720px"/><br/><br/>
        내 용<br/>
        <textarea name="b_contents" id="b_contents" placeholder="내용을 입력하세요." style="width:720px; height:360px"></textarea><br/><br/><br/>
        <center>
            <button type="submit">등록</button>&nbsp;
            <button onclick="history.back(); return false">취소</button>
        </center>
    </form>
</div>