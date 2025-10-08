<?php

require_once("inc/db.php");

//로그인 되어 있는 사용자의 아이디 가져오기
require_once("inc/session.php");
$user_id =$_SESSION['member_id'];

//SELECT table1.col1, table1.col2, ..., table2.col1, table2.col2, ...

// FROM table1 [table1의 별칭]

// JOIN table2 [table2의 별칭] ON table1.col1 = table2.col2

//사용자 아이디에 해당하는 주문정보 가져오기
$result =db_select("select * from pay where member_id= ?", array($user_id));

// var_dump($result);
// echo "<br/>"."<br/>".$result[0]['order_id'];

// foreach($result as $key1=>$value){
//     echo "<br/>"."[order_contents]"."<br/>"."<br/>";
//     $order_contents = json_decode($value["order_contents"]); //string으로 저장되어 있는 json을 배열로 다시 전환시키기 : json_decode
//     var_dump($order_contents);
//     echo "<br/>";


//     foreach($order_contents as $key2=>$order_content){
//         echo "<br/>"."[order_info]"."<br/>"."<br/>";
//         $order_info =db_select("select * from contents where content_code= ?", array($order_contents[$key2]->content_code));
//         var_dump($order_info);
//         echo "<br/>";
//     }

//     // echo $order_content[2]->content_code;
// }





?>