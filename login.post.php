<?php
// ✅ session_start()를 가장 먼저 호출
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("inc/db.php");

// ✅ $_POST['id']와 $_POST['pass']가 없는 경우 기본값 처리
$login_id = $_POST['id'] ?? null;
$password = $_POST['pass'] ?? null;

// 파라미터 체크
if ($login_id === null || $password === null) {
    echo "<script>alert('모두 입력하여 주세요.'); window.location.href='login.php';</script>";
    exit();
}

// 회원 데이터 조회
$member_data = db_select("SELECT * FROM member WHERE login_id = ?", [$login_id]);

// 회원 데이터가 없다면
if ($member_data === false || count($member_data) === 0) {
    echo "<script>alert('회원가입을 먼저하세요.'); window.location.href='login.php';</script>";
    exit();
}

// 입력받은 비밀번호를 SHA-256으로 해시
$hashed_input = hash('sha256', $password);

// DB에 저장된 해시와 비교
$is_match_password = ($hashed_input === $member_data[0]['password']);

// 비밀번호 불일치
if ($is_match_password === false) {
    echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
    exit();
}

// 로그인 성공 시 세션 등록
require_once("inc/session.php");
$_SESSION['member_id'] = $member_data[0]['id'];
$_SESSION['nickname'] = $member_data[0]['nickname'];

// ✅ 메인페이지로 이동 (header() 전에 출력 없어야 함)
header("Location: index.php");
exit();
?>
