
<?php
session_start();
require_once("inc/db.php");
require_once("inc/session.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. 로그인 검증
$member_id = $_SESSION['member_id'] = 17;
if (!isset($_SESSION['member_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    die("로그인이 필요합니다");
}
$member_id = $_SESSION['member_id'];

$conn = new mysqli("localhost:3310", "root", "1111", "luminous_db");
if ($conn->connect_error) {
    http_response_code(400);
    die("DB 연결 실패: " . $conn->connect_error);
}

// 2. 파라미터 검증
$required_fields = ['item_id', 'option_seq', 'cart_count'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        header("HTTP/1.1 400 Bad Request");
        die("필수 필드 누락: $field");
    }
}

$item_id = (int)$_POST['item_id'];
$option_seq = (int)$_POST['option_seq'];
$cart_count = (int)$_POST['cart_count'];
$cart_select = 1;

// 3. item 정보와 함께 product_type 조회 (JOIN 활용)
$item_info = db_select(
    "SELECT item_id, product_type, item_name FROM item WHERE item_id = ?",
    [$item_id]
);

if (empty($item_info)) {
    header("HTTP/1.1 400 Bad Request");
    die("유효하지 않은 상품입니다");
}

$product_type = $item_info[0]['product_type'];
if (empty($product_type)) {
    header("HTTP/1.1 400 Bad Request");
    die("상품 타입 정보가 없습니다");
}

 $product_type= $item_info[0]['product_type'];

// 4. 재고 확인 (product_type에 따라 동적 쿼리)
$stock = 0;
switch ($product_type) {
    case 'CASE':
        $stock_info = db_select(
            "SELECT case_quantity FROM caseoption WHERE case_seq = ?",
            [$option_seq]
        );
        $stock = $stock_info[0]['case_quantity'] ?? 0;
        break;

    case 'WATCH':
        $stock_info = db_select(
            "SELECT watch_quantity FROM watchoption WHERE watch_seq = ?",
            [$option_seq]
        );
        $stock = $stock_info[0]['watch_quantity'] ?? 0;
        break;

    case 'BATTERY':
        $stock_info = db_select(
            "SELECT battery_quantity FROM batteryoption WHERE battery_seq = ?",
            [$option_seq]
        );
        $stock = $stock_info[0]['battery_quantity'] ?? 0;
        break;

    case 'ACCESSORY':
        $stock_info = db_select(
            "SELECT accessory_quantity FROM accessoryoption WHERE accessory_seq = ?",
            [$option_seq]
        );
        $stock = $stock_info[0]['accessory_quantity'] ?? 0;
        break;

    default:
        header("HTTP/1.1 400 Bad Request");
        die("유효하지 않은 옵션 타입입니다");
}

if (empty($stock_info)) {
    header("HTTP/1.1 400 Bad Request");
    die("유효하지 않은 옵션입니다");
}

if ($cart_count > $stock) {
    header("HTTP/1.1 400 Bad Request");
    die("재고 부족: 최대 $stock 개까지 구매 가능");
}

// 5. 장바구니 중복 확인 (JOIN으로 더 많은 정보 가져오기)
$existing = db_select(
    "SELECT c.cart_id, i.item_name
     FROM cart c
     JOIN item i ON c.item_id = i.item_id
     WHERE c.member_id = ? 
     AND c.item_id = ? 
     AND c.product_type = ? 
     AND c.option_seq = ?",
    [$member_id, $item_id, $product_type, $option_seq]
);

if ($existing) {
    $item_name = $existing[0]['item_name'];
    header("HTTP/1.1 409 Conflict");
    die("이미 장바구니에 있는 상품입니다: " . $item_name);
}

// 6. 데이터 삽입
$result = db_insert(
    "INSERT INTO cart (member_id, item_id, product_type, option_seq, cart_count, cart_select) 
     VALUES (:member_id, :item_id, :product_type, :option_seq, :cart_count, :cart_select)",
    [
        'member_id'      => $member_id,
        'item_id'        => $item_id,
        'product_type' => $product_type,
        'option_seq'     => $option_seq,
        'cart_count'     => $cart_count,
        'cart_select'    => $cart_select
    ]
);

if (!$result) {
    header("HTTP/1.1 500 Internal Server Error");
    die("장바구니 추가 실패: DB 오류");
}

// 7. 성공 응답
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => '장바구니에 추가되었습니다',
    'item_name' => $item_info[0]['item_name']
]);
exit;
