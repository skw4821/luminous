<?php
require_once("inc/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 폼 데이터 가져오기
    $content_code = $_POST["content_code"];
    $writer_id = $_POST["writer_id"];
    $review_contents = $_POST["review_contents"];
    $rating = $_POST["rating"];
    $photo = null;

    // 사진 업로드 처리
    if (!empty($_FILES["review_photo"]["name"])) {
        $target_dir = "uploads/reviews/"; // 사진 저장 폴더
        $target_file = $target_dir . basename($_FILES["review_photo"]["name"]);
        move_uploaded_file($_FILES["review_photo"]["tmp_name"], $target_file);
        $photo = $target_file; // 저장된 경로를 DB에 저장
    }

    // 데이터베이스에 리뷰 저장
    $sql = "INSERT INTO review (content_code, writer_id, review_contents, rating, photo, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())";
    $params = array($content_code, $writer_id, $review_contents, $rating, $photo);
    $result = db_insert($sql, $params);

    if ($result) {
        // 성공적으로 저장된 경우
        header("Location: product_detail.php?content_code=" . $content_code);
        exit();
    } else {
        echo "리뷰 작성 중 오류가 발생했습니다. 다시 시도해주세요.";
    }
}
?>
