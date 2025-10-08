<?php 
$content_code = $_POST['content_code'];
$content_options = $_POST['content_options'];
$review_id=date("Ymd") ."_". substr(md5(microtime().mt_rand(1000,2000)),0,6); 
require_once("inc/session.php");
$writer_id =$_SESSION['member_id'];//로그인 되어 있는 사용자의 아이디 가져오기
$review_contents=$_POST['review_contents'];
$star=$_POST['rating'];//별점
$order_id=$_POST['order_id'];//주문번호



//파일 업로드
if ( $_POST[ 'action' ] == "등록" ) {
    require_once("inc/db.php");
    $uploaded_file_name_tmp = $_FILES[ 'photo' ][ 'tmp_name' ];
    $uploaded_file_name = $_FILES[ 'photo' ][ 'name' ];

    if($uploaded_file_name == ""){
        db_insert("insert into review (review_id, writer_id, content_code ,review_contents ,star ) values (:review_id, :writer_id, :content_code ,:review_contents ,:star  )",
            array(
                'review_id' => $review_id,
                'writer_id' => $writer_id,
                'content_code' => $content_code,
                'review_contents' => $review_contents,
                'star' => $star,
            )
        );
    }else{
        try {
            $upload_folder = "img/reviews/";
            $photo = $upload_folder.$uploaded_file_name;
            print_r($photo);

            db_insert("insert into review (review_id, writer_id, content_code ,review_contents ,photo,star ) 
            values (:review_id, :writer_id, :content_code ,:review_contents ,:photo,:star  )",
                array(
                    'review_id' => $review_id,
                    'writer_id' => $writer_id,
                    'content_code' => $content_code,
                    'review_contents' => $review_contents,
                    'photo' => $photo,
                    'star' => $star,
                )
            );

            //파일업로드
            move_uploaded_file( $uploaded_file_name_tmp, $upload_folder . $uploaded_file_name );
            echo "<p>" . $uploaded_file_name . "을(를) 업로드하였습니다.</p>";
        }catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
        
    }

    //리뷰 작성 완료로 바꾸기
    db_update_delete("update pay set review='Y' where order_id=?", array($order_id));

    echo "
            <script>
                alert('리뷰등록이 완료되었습니다.');
                location.href = 'index.php';
            </script>";

    
}



?>