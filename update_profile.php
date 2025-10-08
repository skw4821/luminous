<?php
session_start();
require_once("inc/db.php");

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION['member_id'];

// 입력값 가져오기
$name = trim($_POST['name'] ?? '');
$nickname = trim($_POST['nickname'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone1 = trim($_POST['phone1'] ?? '010');
$phone2 = trim($_POST['phone2'] ?? '');
$phone3 = trim($_POST['phone3'] ?? '');
$email = trim($_POST['email_edit'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$gender = $_POST['gender'] ?? '';

// 필수 입력값 확인
if (!$name || !$nickname || !$address || !$phone2 || !$phone3 || !$email || !in_array($gender, ['M', 'F'])) {
    echo "<script>alert('필수 항목을 모두 입력해 주세요.'); history.back();</script>";
    exit;
}

// 휴대전화 조합
$phone_number = $phone1 . $phone2 . $phone3;

// 비밀번호가 입력된 경우 유효성 체크 및 해시
if ($password) {
    if (strlen($password) < 8) {
        echo "<script>alert('비밀번호는 8자 이상이어야 합니다.'); history.back();</script>";
        exit;
    }
    if ($password !== $password_confirm) {
        echo "<script>alert('비밀번호 확인이 일치하지 않습니다.'); history.back();</script>";
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
}

// gender 값 변환
$gender_db = $gender === 'M' ? 'MALE' : 'FEMALE';

// 업데이트 쿼리 구성
$params = [
    $nickname,
    $name,
    $email,
    $address,
    $phone_number,
    $gender_db,
    $member_id
];

if ($password) {
    $query = "UPDATE Member SET nickname = ?, name = ?, email = ?, address = ?, phone_number = ?, gender = ?, password = ? WHERE member_id = ?";
    array_splice($params, 6, 0, $password_hash); // 6번째 자리에 비밀번호 삽입
} else {
    $query = "UPDATE Member SET nickname = ?, name = ?, email = ?, address = ?, phone_number = ?, gender = ? WHERE member_id = ?";
}

// DB 업데이트 실행
$result = db_update_delete($query, $params);

if ($result) {
    echo "<script>alert('회원정보가 성공적으로 수정되었습니다.'); location.href='mypage.php';</script>";
} else {
    echo "<script>alert('회원정보 수정에 실패했습니다. 다시 시도해 주세요.'); history.back();</script>";
}
?>
