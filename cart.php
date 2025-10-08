<?php
session_start();
require_once("inc/db.php");
require_once("inc/session.php");

// 1. 로그인 검증
$member_id = $_SESSION['member_id'] ?? null;
if (!$member_id) {
    header("Location: login.php");
    exit;
}

// 2. 장바구니 데이터 조회
$cartItems = db_select(
    "SELECT c.*, i.product_type, i.item_name, i.image_id 
     FROM cart c
     INNER JOIN item i ON c.item_id = i.item_id
     WHERE c.member_id = ?",
    [$member_id]
);

// 3. DB 오류 처리
if ($cartItems === false) {
    die("장바구니 조회 중 오류가 발생했습니다.");
}

// 4. 상품 타입 매핑
$productTypeMap = [
    'WATCH' => [
        'table' => 'watchoption',
        'pk' => 'watch_seq',
        'qty' => 'watch_quantity'
    ],
    'BATTERY' => [
        'table' => 'batteryoption',
        'pk' => 'battery_seq',
        'qty' => 'battery_quantity'
    ],
    'CASE' => [
        'table' => 'caseoption',
        'pk' => 'case_seq',
        'qty' => 'case_quantity'
    ],
    'ACCESSORY' => [
        'table' => 'accessoryoption',
        'pk' => 'accessory_seq',
        'qty' => 'accessory_quantity'
    ],
];

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luminous - 장바구니</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Noto Sans KR', sans-serif;
            background-color: #f9f9f9;
            color: #222;
            line-height: 1.5;
        }

        main.main_wrapper.cart {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        .cart_header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .cart_title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .delete_buttons {
            display: flex;
            gap: 10px;
        }

        .delete_buttons button {
            background: #f0f0f0;
            border: 1px solid #ddd;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .delete_buttons button:hover {
            background: #e0e0e0;
        }

        .table {
            width: 100%;
            margin-bottom: 40px;
            border-collapse: collapse;
            background: #fff;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .table_header td {
            font-weight: bold;
            background: #f7f7f7;
            padding: 15px 12px;
            border-bottom: 2px solid #e0e0e0;
            text-align: center;
        }

        td {
            padding: 15px 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .check {
            text-align: center;
        }

        .img_wrapper img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .content_info {
            text-align: left;
            padding-left: 20px;
        }

        .product_name {
            font-weight: 500;
            color: #333;
            margin-top: 5px;
            display: block;
        }

        .product_options {
            color: #666;
            font-size: 14px;
        }

        .order_receipt {
            background: #f9f9f9;
        }

        .order_receipt td.title {
            font-weight: bold;
            font-size: 18px;
            text-align: right;
            padding-right: 20px;
        }

        .total_price {
            font-weight: bold;
            color: #000;
            font-size: 18px;
        }

        .purchase_buttons {
            text-align: center;
            margin-top: 40px;
        }

        .purchase_total,
        .purchase_buttons button {
            background: #000;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 15px 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 0 10px;
        }

        .purchase_total:hover,
        .purchase_buttons button:hover {
            background: #333;
        }

        .quantity-input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }

        @media screen and (max-width: 768px) {
            main.main_wrapper.cart {
                padding: 20px 15px;
            }

            .cart_header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .content_info {
                padding-left: 0;
                text-align: center;
            }

            .purchase_buttons {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .purchase_total,
            .purchase_buttons button {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
</head>

<body>
    <?php require_once("inc/header.php"); ?>
    <form action="cart_delete.php" method="POST" id="delete_form">
    <input type="hidden" name="action" value="delete_selected">
    <input type="hidden" name="cart_select" id="cart_select_input">
</form>

    <main class="main_wrapper cart">
        <section class="cart_header">
            <span class="cart_title">장바구니</span>
            <div class="delete_buttons">
                <button type="button" onclick="deleteSelected()">선택 상품 삭제하기</button>
                <button type="button" onclick="deleteAll()">전체 상품 삭제하기</button>
            </div>
        </section>
        <form action="pay.php" method="POST" name="cart_form">
            <section class="table">
                <table>
                    <tr class="table_header">
                        <td class="check"><input class="check_all" type="checkbox" onchange="checkAll()"></td>
                        <td>이미지</td>
                        <td>상품정보</td>
                        <td>가격</td>
                        <td>수량</td>
                        <td>배송비</td>
                        <td>합계</td>
                    </tr>
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <?php
                            $type = $item['product_type'];
                            $option_seq = $item['option_seq'];
                            $quantity = $item['cart_count'];

                            // 옵션 테이블 정보
                            $table = $productTypeMap[$type]['table'];
                            $pk = $productTypeMap[$type]['pk'];

                            // 옵션 정보 가져오기
                            $option = db_select("SELECT * FROM $table WHERE $pk = ?", [$option_seq])[0] ?? [];
                            if (empty($option)) continue;

                            // 상품 정보 가져오기
                            $itemInfo = db_select("SELECT * FROM item WHERE item_id = ?", [$option['item_id']])[0] ?? [];
                            if (empty($itemInfo)) continue;

                            // 이미지 정보 가져오기
                            $img = db_select("SELECT image_url FROM image WHERE image_id = ?", [$itemInfo['image_id']])[0] ?? ['image_url' => 'default.jpg'];

                            // 가격
                            $price = $option['price'] ?? 0;
                            $total = $price * $quantity;
                            $total_price += $total;
                            ?>
                            <tr>
                                <td class="check"><input type="checkbox" name="cart_select[]" value="<?= $item['cart_id'] ?>"></td>
                                <td>
                                    <div class="img_wrapper">
                                        <img src="<?= htmlspecialchars($img['image_url']) ?>" alt="<?= htmlspecialchars($itemInfo['item_name']) ?>" />
                                    </div>
                                </td>
                                <td class="content_info">
                                    <span class="product_name"><?= htmlspecialchars($itemInfo['item_name']) ?></span>
                                    <span class="product_options">
                                        색상: <?= htmlspecialchars($option['color'] ?? '') ?>
                                        <?php if ($type == 'BATTERY'): ?>
                                            , 용량: <?= htmlspecialchars($option['capacity'] ?? '') ?>
                                        <?php else: ?>
                                            , 사이즈: <?= htmlspecialchars($option['size'] ?? '') ?>
                                        <?php endif; ?>
                                        <?php if (!empty($option['model'])): ?>
                                            , 모델: <?= htmlspecialchars($option['model']) ?>
                                        <?php endif; ?>
                                    </span>
                                    <input type="hidden" name="product_type[]" value="<?= $type ?>">
                                    <input type="hidden" name="option_seq[]" value="<?= $option_seq ?>">
                                </td>
                                <td><?= number_format($price) ?>원</td>
                                <td>
                                    <input type="number" name="quantity[]" value="<?= $quantity ?>" min="1" class="quantity-input">
                                </td>
                                <td>무료배송</td>
                                <td><?= number_format($total) ?>원</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align:center; padding:40px 0; color:#666;">장바구니에 상품이 없습니다.</td>
                        </tr>
                    <?php endif; ?>
                    <tr class="order_receipt">
                        <td colspan="6" style="text-align:right; padding-right:20px; font-weight:bold;">합계</td>
                        <td>
                            <span class="total_price"><?= number_format($total_price) ?>원</span>
                        </td>
                    </tr>
                </table>
            </section>
            <section class="purchase_buttons">
                <button type="submit" class="purchase_total">전체 상품 주문하기</button>
                <button type="button" onclick="CheckSelected()">선택 상품 주문하기</button>
            </section>
        </form>
    </main>

    <?php require_once("inc/footer.php"); ?>

    <script>
        function checkAll() {
            const checkboxes = document.querySelectorAll('input[name="cart_select[]"]');
            const masterCheckbox = document.querySelector('.check_all');
            checkboxes.forEach(checkbox => {
                checkbox.checked = masterCheckbox.checked;
            });
        }

        function CheckSelected() {
            const checkboxes = document.querySelectorAll('input[name="cart_select[]"]:checked');
            if (checkboxes.length === 0) {
                alert('선택된 상품이 없습니다.');
                return;
            }
            document.forms['cart_form'].submit();
        }

        function deleteSelected() {
    const checkboxes = document.querySelectorAll('input[name="cart_select[]"]:checked');
    if (checkboxes.length === 0) {
        alert('삭제할 상품을 선택해주세요.');
        return;
    }
    const ids = Array.from(checkboxes).map(c => c.value).join(',');
    document.getElementById('cart_select_input').value = ids;
    document.getElementById('delete_form').submit();
}

function deleteAll() {
    if (confirm('장바구니의 모든 상품을 삭제하시겠습니까?')) {
        // action을 delete_all로 변경
        document.querySelector('#delete_form input[name="action"]').value = 'delete_all';
        document.getElementById('cart_select_input').value = '';
        document.getElementById('delete_form').submit();
    }
}
    </script>
</body>

</html>