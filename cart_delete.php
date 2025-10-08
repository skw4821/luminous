<?php
session_start();
require_once("inc/db.php");
require_once("inc/session.php");
$member_id = $_SESSION['member_id'] = 17;

$member_id = $_SESSION['member_id'] ?? null;
if (!$member_id) {
    die("로그인이 필요합니다.");
}

$action = $_POST['action'] ?? '';
$cart_select = $_POST['cart_select'] ?? '';

if ($action === 'delete_selected' && $cart_select) {
    $ids = explode(',', $cart_select);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $params = array_merge([$member_id], $ids);
    $result = db_update_delete(
        "DELETE FROM cart WHERE member_id = ? AND cart_id IN ($placeholders)",
        $params
    );
} elseif ($action === 'delete_all') {
    $result = db_update_delete(
        "DELETE FROM cart WHERE member_id = ?",
        [$member_id]
    );
}

if ($result) {
    header("Location: cart.php");
} else {
    die("삭제 실패: DB 오류");
}
exit;
?>
