<?php
// ✅ 세션 시작 (헤더 전송 전)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// ✅ header.php에서 $currentPage 사용하므로 미리 정의
$currentPage = 'product_detail';
require_once("inc/db.php");

// 1. 상품 ID 확인
$item_id = (int)$_GET['item_id'] ?? 0;
if ($item_id === 0) die("상품 ID가 유효하지 않습니다.");

// 2. 상품 정보 + 이미지 URL 조회 (JOIN 사용)
$item = db_select(
    "SELECT i.*, img.image_url 
     FROM item i 
     LEFT JOIN image img ON i.image_id = img.image_id 
     WHERE i.item_id = ?",
    [$item_id]
)[0] ?? [];

if (empty($item)) die("상품이 존재하지 않습니다.");

// 3. 상품 타입에 따른 옵션 테이블 매핑
$product_type = $item['product_type'] ?? '';
$option_table_map = [
    'CASE' => ['table' => 'caseoption', 'pk' => 'case_seq'],
    'WATCH' => ['table' => 'watchoption', 'pk' => 'watch_seq'],
    'BATTERY' => ['table' => 'batteryoption', 'pk' => 'battery_seq'],
    'ACCESSORY' => ['table' => 'accessoryoption', 'pk' => 'accessory_seq']
];

// 4. 옵션 데이터 조회 (PK를 option_seq로 통일)
$options = [];
if (isset($option_table_map[$product_type])) {
    $table = $option_table_map[$product_type]['table'];
    $pk = $option_table_map[$product_type]['pk'];
    $options = db_select(
        "SELECT $pk AS option_seq, color, size, model, price 
         FROM $table 
         WHERE item_id = ?",
        [$item_id]
    ) ?? [];
}

// 5. 옵션 색상 추출 (안전하게 처리)
$colors = array_column($options, 'color') ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luminous</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    body {
        background-color: #f8f8f8;
        font-family: 'Arial', sans-serif;
        color: #333;
    }
    .main_wrapper_contents_detail {
        max-width: 1000px;
        margin: auto;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .top_left .main-img img {
        width: 100%;
        max-width: 350px;
        border-radius: 10px;
    }
    .top_right {
        flex: 1;
        padding: 20px;
    }
    .product-title {
        font-size: 26px;
        font-weight: bold;
        color: #000;
    }
    .price-section {
        margin: 10px 0;
        font-size: 18px;
    }
    .original-price {
        text-decoration: line-through;
        color: #888;
    }
    .discount-price {
        color: #d32f2f;
        font-weight: bold;
    }
    .price_final {
        font-size: 22px;
        font-weight: bold;
        color: #000;
    }
    .buttons.choice {
        margin: 15px 0;
    }
    .op_button select {
        padding: 8px;
        font-size: 16px;
        background-color: #ffffff;
        border: 1px solid #ddd;
        cursor: pointer;
    }
    .total_price_wrapper {
        font-size: 20px;
        font-weight: bold;
        color: #000;
        margin-top: 20px;
    }
    .purchase-section button {
        background-color: #000;
        color: #fff;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        font-size: 18px;
        margin-right: 10px;
        transition: 0.3s ease-in-out;
    }
    .purchase-section button:hover {
        background-color: #333;
    }
    .review-item {
        padding: 15px;
        background-color: #fff;
        border-radius: 5px;
        margin-bottom: 10px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
    }
    .review-author {
        font-weight: bold;
        color: #000;
    }
    .review-rating {
        color: #ff9800;
    }
    .top_left .main-img {
        width: 100%;
        max-width: 500px;
        height: 400px;
        background-color: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
    .top_left .main-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .tab-menu {
        max-width: 800px;
        margin: 40px auto;
        position: relative;
    }
    .tabs {
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 10px;
        position: relative;
    }
    .tab-btn {
        flex: 1;
        background-color: transparent;
        color: #000;
        padding: 14px 28px;
        border: 2px solid #ccc;
        border-bottom: none;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
        transition: 0.3s;
    }
    .tab-btn:hover,
    .tab-btn.active {
        border-color: #000;
        border-bottom: none;
        color: #000;
    }
    .tabs::after {
        content: "";
        width: 100%;
        height: 2px;
        background-color: #000;
        position: absolute;
        bottom: 0;
        left: 0;
    }
    .tab-content {
        background-color: #fff;
        padding: 30px;
        border-radius: 0;
        box-shadow: none;
        margin-top: 0;
        text-align: left;
        display: none;
    }
    #details {
        display: block;
    }
</style>
<body class="detail">
    <?php require_once("inc/header.php"); ?>

    <main class="main_wrapper_contents_detail">
        <form class="top" name="contents_form">
            <input type="hidden" name="item_id" value="<?= $item_id ?>">
            <input type="hidden" name="option_seq" id="option_seq" value="">

            <section class="top_left">
                <div class="main-img">
                    <img src="<?= htmlspecialchars($item['image_url'] ?? 'images/default.jpg') ?>" alt="<?= htmlspecialchars($item['item_name']) ?>">
                </div>
            </section>

            <section class="top_right">
                <h1 class="product-title"><?= htmlspecialchars($item['item_name']) ?></h1>
                <div class="price-section">
                </div>
                <div class="buttons choice">
                    <span class="choice_title">색상</span>
                    <div class="op_button">
                        <select id="colorSelect" name="selected_color" required onchange="updateTotalPrice()">
                            <option value="">색상 선택</option>
                            <?php foreach ($options as $opt): ?>
                                <option value="<?= htmlspecialchars($opt['color']) ?>"
                                    data-seq="<?= $opt['option_seq'] ?>"
                                    data-price="<?= $opt['price'] ?>">
                                    <?= htmlspecialchars($opt['color']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="buttons choice">
                    <span class="choice_title">사이즈</span>
                    <div class="op_button">
                        <select id="sizeSelect" name="selected_size" required onchange="updateTotalPrice()">
                            <option value="">사이즈 선택</option>
                            <?php foreach ($options as $opt): ?>
                                <option value="<?= htmlspecialchars($opt['size']) ?>"
                                    data-seq="<?= $opt['option_seq'] ?>"
                                    data-price="<?= $opt['price'] ?>">
                                    <?= htmlspecialchars($opt['size']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="buttons choice">
                    <span class="choice_title">모델</span>
                    <div class="op_button">
                        <select id="modelSelect" name="selected_model" required onchange="updateTotalPrice()">
                            <option value="">모델 선택</option>
                            <?php foreach ($options as $opt): ?>
                                <option value="<?= htmlspecialchars($opt['model']) ?>"
                                    data-seq="<?= $opt['option_seq'] ?>"
                                    data-price="<?= $opt['price'] ?>">
                                    <?= htmlspecialchars($opt['model']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="total_price_wrapper">
                    <span class="total_price_title">총 결제 금액: </span>
                    <span class="total_price">0</span>원
                </div>
                <script>
                    const productOptions = <?= json_encode($options) ?>;
                </script>
                <div class="insert_contents">
                    <div class="content content1">
                        <section class="option1">
                            <span class="color option1_color"></span>
                            <span class="size option1_size"></span>
                            <input type="hidden" name="content_options" value="none" />
                        </section>
                        <section class="option2">
                            <span class="amount_label">수량:</span>
                            <input type="number" name="cart_count" min="1" class="amount" value="1">
                        </section>
                    </div>
                </div>
                <div class="purchase-section">
                    <button type="button" class="buy-now-btn" onclick="addToCartAndRedirect();"><span>구매하기</span></button>
                    <button type="button" class="add-cart-btn" onclick="cart_insert()"><span>장바구니</span></button>
                    <button type="button" class="user-btn" onclick="location.href='custom.php?item_id=<?= $item_id ?>'"><span>커스텀 디자인</span></button>
                </div>
            </section>
        </form>
        <section class="tab-menu">
            <div class="tabs">
                <button class="tab-btn active" onclick="showTab('details', this)">상품 상세정보</button>
                <button class="tab-btn" onclick="showTab('reviews', this)">상품 리뷰</button>
                <button class="tab-btn" onclick="showTab('inquiry', this)">상품 문의</button>
            </div>
            <div class="tab-content" id="details">
                <h2>📌 상품 상세정보</h2>
                <p>상품의 특징, 재료, 사용법 등을 설명하는 공간입니다.</p>
            </div>
            <div class="tab-content" id="reviews">
                <h2>📝 상품 리뷰</h2>
                <section class="reviews-section">
                    <section class="review-write-section">
                        <h2>리뷰 작성하기</h2>
                        <form class="review-write-form" action="review.insert.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="content_code" value="<?= $item_id ?>">
                            <!-- ... 기존 리뷰 작성 폼 내용 ... -->
                        </form>
                    </section>
                    <section class="review-list-section">
                        <h2>작성된 리뷰</h2>
                        <?php if (!empty($review)): ?>
                            <div class="review-list">
                                <?php foreach ($review as $r): ?>
                                    <div class="review-item">
                                        <div class="review-header">
                                            <span class="review-author"><?= htmlspecialchars($r['writer_id']) ?></span>
                                            <span class="review-rating">
                                                <?= str_repeat('★', $r['star']) ?><?= str_repeat('☆', 5 - $r['star']) ?>
                                            </span>
                                        </div>
                                        <div class="review-content">
                                            <p><?= nl2br(htmlspecialchars($r['review_contents'])) ?></p>
                                        </div>
                                        <?php if ($r['photo']): ?>
                                            <div class="review-photo">
                                                <img src="uploads/<?= htmlspecialchars($r['photo']) ?>" alt="리뷰 이미지">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>아직 작성된 리뷰가 없습니다.</p>
                        <?php endif; ?>
                    </section>
                </section>
            </div>
            <div class="tab-content" id="inquiry">
                <h2>❓ 상품 문의</h2>
                <p>상품에 대한 궁금한 사항을 질문하는 공간입니다.</p>
            </div>
        </section>
    </main>

    <?php require_once("inc/footer.php"); ?>

    <script>
        // 옵션 변경 시 실행될 함수 (수정)
        function updateTotalPrice() {
            const color = $("#colorSelect option:selected").val();
            const size = $("#sizeSelect option:selected").val();
            const model = $("#modelSelect option:selected").val();
            const quantity = parseInt($("input[name='cart_count']").val()) || 1;

            // ✅ `productOptions`에서 옵션 찾기
            const selectedOption = productOptions.find(opt =>
                opt.color === color &&
                opt.size === size &&
                opt.model === model
            );

            if (selectedOption) {
                const total = selectedOption.price * quantity;
                $(".total_price").text(total.toLocaleString());
                $("#option_seq").val(selectedOption.option_seq);
            } else {
                $(".total_price").text("0");
                $("#option_seq").val("");
            }
        }

        // ✅ 모든 select 요소에 이벤트 리스너 추가
        $("#colorSelect, #sizeSelect, #modelSelect").on("change", updateTotalPrice);
        $("input[name='cart_count']").on("input", updateTotalPrice);

        // 초기 실행
        updateTotalPrice();

        function selectOption(seq) {
            document.getElementById('option_seq').value = seq;
        }

        function addToCartAndRedirect() {
            const optionSeq = $("input[name='option_seq']").val();
            if (!optionSeq) {
                alert('옵션을 선택해 주세요.');
                return;
            }
            const formData = $("form[name='contents_form']").serialize();
            $.ajax({
                url: "cart_insert.php",
                method: "POST",
                data: formData,
                dataType: 'json',
                xhrFields: {
                    withCredentials: true
                },
                success: function(response) {
                    if (response && response.success) {
                        window.location.href = 'pay.php';
                    } else {
                        alert('장바구니 추가에 실패했습니다.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log("장바구니 추가 실패:", xhr, status, error);
                    if (xhr.status === 401) {
                        alert("로그인이 필요합니다.");
                        window.location.href = 'login.php';
                    } else {
                        alert('장바구니에 추가하는 데 실패했습니다.');
                    }
                }
            });
        }

        function cart_insert() {
            const optionSeq = $("input[name='option_seq']").val();
            if (!optionSeq) {
                alert('옵션을 선택해 주세요.');
                return;
            }
            const formData = $("form[name='contents_form']").serialize();
            $.ajax({
                url: "cart_insert.php",
                method: "POST",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('장바구니에 추가되었습니다.');
                        window.location.href = 'cart.php';
                    } else {
                        alert(response.message || '장바구니 추가 실패');
                    }
                },
                error: function(xhr) {
                    console.log("장바구니 추가 실패:", xhr);
                    if (xhr.status === 401) {
                        alert("로그인이 필요합니다.");
                        window.location.href = 'login.php';
                    } else if (xhr.status === 409) {
                        alert(xhr.responseJSON?.message || '이미 장바구니에 있는 상품입니다');
                    } else {
                        alert('장바구니 추가 실패: 서버 오류');
                    }
                }
            });
        }

        function showTab(tabId, element) {
            $(".tab-content").hide();
            $("#" + tabId).show();
            $(".tab-btn").removeClass("active");
            $(element).addClass("active");
        }
    </script>
</body>
</html>
