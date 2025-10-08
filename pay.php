<?php
session_start();
$member_id = $_SESSION['member_id'] = 17;
$member_id = $_SESSION['member_id'];
require_once("inc/session.php");
require_once("inc/db.php");

// 장바구니 조회 (JOIN으로 item 정보, 이미지까지 한 번에 가져오기)
$cart_items = db_select(
    "SELECT c.*, i.item_name, i.image_id, i.product_type
     FROM cart c
     JOIN item i ON c.item_id = i.item_id
     WHERE c.member_id = ?",
    [$member_id]
);

$total_price = 0; // 총액 초기화
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luminous - 주문/결제</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
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
    main.cart_wrapper.pay {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        background: #fff;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        border-radius: 8px;
    }
    .pay_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .pay_title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
    }
    .back_buttons button {
        background: #f0f0f0;
        border: 1px solid #ddd;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .back_buttons button:hover {
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
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
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
    .img_wrapper img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .content_info {
        text-align: left;
        padding-left: 20px;
    }
    .content_name {
        font-weight: 500;
        color: #333;
        margin-top: 5px;
        display: block;
    }
    .content_options {
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
    .order_info {
        margin-bottom: 40px;
    }
    .table_info td {
        font-weight: bold;
        padding: 10px 0;
        font-size: 18px;
    }
    .custom_ord_info {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    .ord_info,
    .deliv_info {
        border: 1px solid #e0e0e0;
        padding: 25px;
        border-radius: 8px;
        background: #fff;
    }
    .custom_info,
    .delivery_info {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 20px;
        color: #333;
    }
    .ord_name,
    .ord_email_wrapper,
    .ord_number_wrapper,
    .deliv_name,
    .deliv_address_wrapper,
    .deliv_number_wrapper,
    .deliv_message {
        margin-bottom: 15px;
    }
    input[type="text"],
    select {
        padding: 10px;
        margin: 4px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        width: auto;
        max-width: 100%;
    }
    .deliv_text_info_name,
    .ord_text_info_name {
        width: 200px;
    }
    .info_text_email,
    .deliv_text_post_code,
    .deliv_search_road_name,
    .deliv_detail_address,
    .deliv_text_info_message {
        width: 100%;
        max-width: 300px;
    }
    .ord_email,
    .ord_phone_number,
    .deliv_phone_number {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
    }
    .ord_email li,
    .ord_phone_number li,
    .deliv_phone_number li {
        margin: 0;
    }
    .deliv_post_code,
    .deliv_road_name,
    .deliv_detail_post {
        margin-bottom: 10px;
    }
    .deliv_search_code button {
        background: #f0f0f0;
        border: 1px solid #ccc;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .deliv_search_code button:hover {
        background: #e0e0e0;
    }
    .choose_imp {
        color: #ff5050;
        font-size: 14px;
        display: inline;
        margin-left: 5px;
    }
    .order_buttons {
        text-align: center;
        margin-top: 40px;
    }
    .order_total {
        padding: 15px 40px;
        background: #000;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .order_total:hover {
        background: #333;
    }
    @media screen and (max-width: 768px) {
        main.cart_wrapper.pay {
            padding: 20px 15px;
        }
        .pay_header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        .content_info {
            padding-left: 0;
            text-align: center;
        }
        .ord_email,
        .ord_phone_number,
        .deliv_phone_number {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
        input[type="text"],
        select {
            width: 100%;
        }
        .ord_text_info_name,
        .deliv_text_info_name {
            width: 100%;
        }
    }
</style>

<body>
    <?php require_once("inc/header.php"); ?>

    <main class="cart_wrapper pay">
        <section class="pay_header">
            <span class="pay_title">주문/결제</span>
            <div class="back_buttons">
                <a href="cart.php"><button>< 이전 페이지</button></a>
            </div>
        </section>

        <section class="table">
            <table>
                <tr class="table_header">
                    <td>이미지</td>
                    <td>상품정보</td>
                    <td>가격</td>
                    <td>수량</td>
                    <td>배송비</td>
                    <td>합계</td>
                </tr>
                <?php if (!empty($cart_items)): ?>
                    <?php foreach ($cart_items as $item): ?>
                        <?php
                        // 이미지 조회
                        $img = db_select(
                            "SELECT image_url FROM image WHERE image_id = ?",
                            [$item['image_id']]
                        )[0] ?? ['image_url' => 'default.jpg'];

                        // 옵션 정보 조회 (예시: case, watch 등)
                        $type_map = [
                            'CASE'      => ['table' => 'caseoption',     'fields' => ['color', 'size', 'model'], 'pk' => 'case_seq'],
                            'WATCH'     => ['table' => 'watchoption',    'fields' => ['color', 'size', 'model'], 'pk' => 'watch_seq'],
                            'BATTERY'   => ['table' => 'batteryoption',  'fields' => ['color', 'size', 'model'], 'pk' => 'battery_seq'],
                            'ACCESSORY' => ['table' => 'accessoryoption','fields' => ['color', 'size', 'model'], 'pk' => 'accessory_seq'],
                        ];

                        $product_type = strtoupper($item['product_type']);
                        if (!isset($type_map[$product_type])) {
                            $option_data = [];
                            $price = 0;
                        } else {
                            $option_data = db_select(
                                "SELECT " . implode(', ', $type_map[$product_type]['fields']) . "
                                 FROM {$type_map[$product_type]['table']}
                                 WHERE {$type_map[$product_type]['pk']} = ?",
                                [$item['option_seq']]
                            )[0] ?? [];

                            $price = db_select(
                                "SELECT price FROM {$type_map[$product_type]['table']}
                                 WHERE {$type_map[$product_type]['pk']} = ?",
                                [$item['option_seq']]
                            )[0]['price'] ?? 0;
                        }

                        $total = $price * $item['cart_count'];
                        $total_price += $total;
                        ?>
                        <tr>
                            <td>
                                <div class="img_wrapper">
                                    <img src="<?= htmlspecialchars($img['image_url']) ?>" alt="<?= htmlspecialchars($item['item_name']) ?>" />
                                </div>
                            </td>
                            <td class="content_info">
                                <span class="content_options">
                                    <?php
                                    if (!empty($option_data)) {
                                        $option_str = [];
                                        foreach ($type_map[$product_type]['fields'] as $field) {
                                            if (isset($option_data[$field])) {
                                                $option_str[] = htmlspecialchars($option_data[$field]);
                                            }
                                        }
                                        echo implode(', ', $option_str);
                                    }
                                    ?>
                                </span>
                                <span class="content_name"><?= htmlspecialchars($item['item_name']) ?></span>
                            </td>
                            <td>
                                <?= number_format($price) ?>원
                            </td>
                            <td class="content_info">
                                <?= $item['cart_count'] ?>개
                            </td>
                            <td>무료배송</td>
                            <td>
                                <?= number_format($total) ?>원
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px 0; color:#666;">장바구니에 상품이 없습니다.</td>
                    </tr>
                <?php endif; ?>

                <tr class="order_receipt">
                    <td colspan="5" style="text-align:right; padding-right:20px; font-weight:bold;">총 결제 금액</td>
                    <td>
                        <span class="total_price">
                            <?= isset($total_price) ? number_format($total_price) . '원' : '0원' ?>
                        </span>
                    </td>
                </tr>
            </table>
        </section>

        <form action="pay_insert.php" method="POST">
            <section class="order_info">
                <table>
                    <tr class="table_info">
                        <td>주문 정보</td>
                        <td class="import_text">* 필수 입력 사항</td>
                    </tr>
                </table>
                <div class="custom_ord_info">
                    <div class="ord_info">
                        <div class="custom_info">01. 주문자 정보</div>
                        <div class="ord_name">
                            <label>이름: <input name="orderer_name" required type="text" maxlength="25" class="ord_text_info_name" /></label>
                        </div>
                        <div class="ord_email_wrapper">
                            <label>이메일:
                                <div class="ord_email_write">
                                    <input name="orderer_email1" required type="text" class="info_text_email" maxlength="20">
                                    @
                                    <input name="orderer_email2" type="text" class="info_text_email" maxlength="20" placeholder="직접입력">
                                </div>
                                <ul class="ord_email">
                                    <li>
                                        <select class="ord_text_info_email" id="info_email" name="orderer_email2_select">
                                            <option value="">선택</option>
                                            <option value="gmail.com">gmail.com</option>
                                            <option value="naver.com">naver.com</option>
                                            <option value="daum.net">daum.net</option>
                                        </select>
                                    </li>
                                </ul>
                            </label>
                        </div>
                        <div class="ord_number_wrapper">
                            <label>휴대전화:
                                <ul class="ord_phone_number">
                                    <li>
                                        <select id="info01" class="ord_text_info_number" name="orderer_phone1">
                                            <option value="">선택</option>
                                            <option value="010">010</option>
                                            <option value="011">011</option>
                                            <option value="016">016</option>
                                            <option value="017">017</option>
                                        </select>
                                    </li>
                                    <li>
                                        -
                                        <input name="orderer_phone2" required type="text" id="info02" class="ord_info_center_number" size="4" onkeypress="onlyNumber();" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    </li>
                                    <li>
                                        -
                                        <input name="orderer_phone3" required type="text" id="info03" class="ord_info_last_number" size="4" onkeypress="onlyNumber();" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    </li>
                                </ul>
                            </label>
                        </div>
                    </div>
                    <div class="deliv_info">
                        <div class="delivery_info">02. 배송 정보</div>
                        <div class="dest_choose">
                            배송지 선택
                            <span class="choose_imp">*</span>
                        </div>
                        <div class="deliv_name">
                            <label>받는분: <input name="Recipient_name" required type="text" maxlength="25" class="deliv_text_info_name" /></label>
                        </div>
                        <div class="deliv_address_wrapper">
                            <label>주소:
                                <div class="deliv_check">
                                    <div class="form">
                                        <div class="deliv_do_fore">
                                            <input type="radio" name="domestic" checked> 국내
                                            <input type="radio" name="domestic"> 해외
                                        </div>
                                    </div>
                                    <div class="deliv_post_code">
                                        <input name="zip_code" type="text" class="deliv_text_post_code" id="postcode" placeholder="우편번호" readonly />
                                        <div class="deliv_search_code">
                                            <button type="button" class="deliv_search_post_code" onclick="">우편번호</button>
                                        </div>
                                    </div>
                                    <div class="deliv_road_name">
                                        <input name="address1" type="text" class="deliv_search_road_name" id="address" placeholder="주소" readonly />
                                    </div>
                                    <div class="deliv_detail_post">
                                        <input name="address2" type="text" class="deliv_detail_address" placeholder="상세 주소 입력" required />
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="deliv_number_wrapper">
                            <label>휴대전화:
                                <ul class="deliv_phone_number">
                                    <li>
                                        <select name="Recipient_phone1" id="info001" class="deliv_text_info_number">
                                            <option value="">선택</option>
                                            <option value="010">010</option>
                                            <option value="011">011</option>
                                            <option value="016">016</option>
                                            <option value="017">017</option>
                                        </select>
                                    </li>
                                    <li>
                                        -
                                        <input name="Recipient_phone2" required type="text" id="info002" class="deliv_info_center_number" size="4" onkeypress="onlyNumber();" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    </li>
                                    <li>
                                        -
                                        <input name="Recipient_phone3" required type="text" id="info003" class="deliv_info_last_number" size="4" onkeypress="onlyNumber();" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    </li>
                                </ul>
                            </label>
                        </div>
                        <div class="deliv_message">
                            <label>배송 메시지: <input name="message" type="text" maxlength="30" class="deliv_text_info_message" /></label>
                        </div>
                    </div>
                </div>
            </section>
            <section class="order_buttons">
                <button class="order_total">주문하기</button>
            </section>
        </form>
    </main>

    <?php require_once("inc/footer.php"); ?>

    <script src="https://kit.fontawesome.com/73fbcb87e6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script src="js/hot_issue.js"></script>
    <script src="js/member.js"></script>
    <script>
        // 이메일 도메인 선택 시 직접입력 필드에 값 넣기
        document.getElementById('info_email').addEventListener('change', function() {
            if (this.value) {
                document.querySelector('input[name="orderer_email2"]').value = this.value;
            }
        });
    </script>
</body>
</html>
