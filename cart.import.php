<?php
session_start();
require_once("inc/db.php");
require_once("inc/session.php");

// 1. 세션 검증
$member_id = $_SESSION['member_id'] = 17;
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

// 2. 옵션 매핑 테이블 (소문자 키 사용)
$typeMap = [
    'watch'     => ['table' => 'watchoption',     'pk' => 'watch_seq',  'fields' => ['color', 'size', 'model']],
    'battery'   => ['table' => 'batteryoption',   'pk' => 'battery_seq','fields' => ['color', 'capacity']],
    'case'      => ['table' => 'caseoption',      'pk' => 'case_seq',   'fields' => ['color', 'size', 'model']],
    'accessory' => ['table' => 'accessoryoption', 'pk' => 'accessory_seq','fields' => ['color', 'size', 'model']]
];

// 3. 장바구니 데이터 조회
$result = db_select("
    SELECT 
        c.cart_id,
        c.item_id,
        c.option_type,
        c.option_seq,
        c.cart_count,
        i.item_name,
        i.image_id  -- item 테이블의 image_id 사용
    FROM cart c
    LEFT JOIN item i ON c.item_id = i.item_id
    WHERE c.member_id = ?
", [$_SESSION['member_id']]);

$total_price = 0;

foreach($result as $row):
    $type = $row['option_type'];
    if (!isset($typeMap[$type])) continue;

    // 4. 옵션 정보 조회
    $config = $typeMap[$type];
    $option = db_select(
        "SELECT " . implode(', ', $config['fields']) . " 
        FROM {$config['table']} 
        WHERE {$config['pk']} = ?",
        [$row['option_seq']]
    )[0] ?? [];

    // 5. 이미지 조회 (item.image_id 사용)
    $img = db_select(
        "SELECT image_url FROM image WHERE image_id = ?",
        [$row['image_id']]
    )[0] ?? ['image_url' => 'default.jpg'];

    // 6. 가격 계산
    $price = db_select(
        "SELECT price FROM {$config['table']} 
        WHERE {$config['pk']} = ?",
        [$row['option_seq']]
    )[0]['price'] ?? 0;
    
    $total = $price * $row['cart_count'];
    $total_price += $total;
?>
<!-- HTML 출력 부분 -->
<tr>
    <td><img src="<?= htmlspecialchars($img['image_url']) ?>" width="80"></td>
    <td><?= htmlspecialchars($row['item_name']) ?></td>
    <td>
        <?= implode(', ', array_map(function($field) use ($option) {
            return htmlspecialchars($option[$field] ?? '');
        }, $config['fields'])) ?>
    </td>
    <td><?= number_format($price) ?>원</td>
    <td>
        <input type="number" value="<?= $row['cart_count'] ?>" 
               data-cart-id="<?= $row['cart_id'] ?>" 
               class="quantity-update" min="1">
    </td>
    <td><?= number_format($total) ?>원</td>
    <td><button class="delete-item" data-cart-id="<?= $row['cart_id'] ?>">삭제</button></td>
</tr>
<?php endforeach; ?>

<!-- 총 합계 표시 -->
<tr class="total-row">
    <td colspan="5">총 합계</td>
    <td><?= number_format($total_price) ?>원</td>
</tr>

<!-- AJAX 처리 스크립트 추가 -->
<script>
document.querySelectorAll('.quantity-update').forEach(input => {
    input.addEventListener('change', function() {
        fetch('update_cart.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                cart_id: this.dataset.cartId,
                quantity: this.value
            })
        }).then(response => location.reload());
    });
});

document.querySelectorAll('.delete-item').forEach(btn => {
    btn.addEventListener('click', function() {
        if (confirm('정말 삭제하시겠습니까?')) {
            fetch('delete_cart.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ cart_id: this.dataset.cartId })
            }).then(response => location.reload());
        }
    });
});
</script>
