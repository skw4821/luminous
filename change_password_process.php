<?php
session_start();
require_once("inc/db.php");

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

// POST 방식으로만 동작
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

$member_id = $_SESSION['member_id'];
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// 새 비밀번호 확인
if ($new_password !== $confirm_password) {
    echo "<script>alert('새 비밀번호가 일치하지 않습니다.'); history.back();</script>";
    exit;
}

try {
    $pdo = db_get_pdo();

    // 기존 비밀번호 조회
    $stmt = $pdo->prepare("SELECT password FROM Member WHERE member_id = ?");
    $stmt->execute([$member_id]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($current_password, $user['password'])) {
        echo "<script>alert('현재 비밀번호가 올바르지 않습니다.'); history.back();</script>";
        exit;
    }

    // 새 비밀번호 암호화 및 저장
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    $update_stmt = $pdo->prepare("UPDATE Member SET password = ? WHERE member_id = ?");
    $update_stmt->execute([$hashed_new_password, $member_id]);

    // 로그아웃 처리
    session_destroy();

    echo "<script>alert('비밀번호가 성공적으로 변경되었습니다. 다시 로그인해 주세요.'); location.href='login.php';</script>";
    exit;

} catch (Exception $e) {
    echo "<script>alert('오류가 발생했습니다: " . addslashes($e->getMessage()) . "'); history.back();</script>";
    exit;
}
?>
