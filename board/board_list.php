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

.boardList {
    font-size:10pt;
    text-align:left;
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
$sql = sql_query("select * from bd__board order by b_idx desc");

while ($data = $sql->fetch_assoc()):
?>
        <a href="./board_view.php?b_idx=<?=$data['b_idx']?>"><?=$data['b_title']?></a><br/>
<?php endwhile?>
    </div>
</div>