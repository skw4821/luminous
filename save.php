<?php
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['image'])) {
    die("이미지 데이터가 없습니다.");
}

$imageData = $data['image'];
$imageData = str_replace('data:image/png;base64,', '', $imageData);
$imageData = base64_decode($imageData);

$fileName = "design_" . time() . ".png";
file_put_contents("uploads/" . $fileName, $imageData);

echo "uploads/" . $fileName;
?>
