<?php
// MySQL 연결 설정
$conn = new mysqli("localhost", "root", "1111", "luminous_db", 3310);
$conn->set_charset("utf8mb4");

// URL 파라미터 처리 (프로그래밍.자료구조 관점)
$search_term = $_GET['content_field'] ?? '';
$decoded_term = urldecode($search_term);
$like_term = "%$decoded_term%"; // 부분 일치 검색

// 정렬 시스템 설정
$allowed_sorts = [
    'new' => 'item_id DESC',
    'name' => 'item_name ASC',
    'low' => 'price ASC',
    'high' => 'price DESC'
];
$sort = isset($_GET['sort']) && isset($allowed_sorts[$_GET['sort']]) ? $_GET['sort'] : 'new';

$base_sql = "SELECT 
                i.item_id, 
                i.item_name, 
                img.image_url, 
                MIN(all_prices.price) AS price
            FROM Item i
            INNER JOIN Image img ON i.image_id = img.image_id
            LEFT JOIN (
                -- 모든 옵션 테이블을 UNION ALL로 통합
                SELECT item_id, price FROM CaseOption
                UNION ALL
                SELECT item_id, price FROM WatchOption
                UNION ALL
                SELECT item_id, price FROM BatteryOption
                UNION ALL
                SELECT item_id, price FROM AccessoryOption
            ) all_prices ON i.item_id = all_prices.item_id
            WHERE i.item_name LIKE ?
            GROUP BY i.item_id, i.item_name, img.image_url
            ORDER BY " . $allowed_sorts[$sort];


// 페이지네이션
$page = max(1, (int)($_GET['page'] ?? 1));
$items_per_page = 8;
$offset = ($page - 1) * $items_per_page;

// 쿼리 실행 (Prepared Statement)
$stmt = $conn->prepare($base_sql . " LIMIT ?, ?");
$stmt->bind_param("sii", $like_term, $offset, $items_per_page);
$stmt->execute();
$result = $stmt->get_result();

// 전체 개수 조회
$count_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM Item WHERE item_name LIKE ?");
$count_stmt->bind_param("s", $like_term);
$count_stmt->execute();
$total_items = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);
?>



<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>Luminous</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            all: unset;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        .main-content {
            max-width: 1200px;
            margin: 120px auto 40px auto;
            /* 헤더 아래 80px 여백 */
            padding: 0 20px;
        }

        .sale-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .filter-section {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .filter-section a {
            text-decoration: none;
            color: #555;
            font-weight: normal;
        }

        .filter-section a.active-filter {
            font-weight: bold;
            color: #000;
        }

        .products-container_f {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 30px;
        }

        .product {
            background: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            transition: box-shadow 0.2s ease;
            padding: 15px;
        }

        .product:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .product-image img {
            width: 100%;
            height: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .product:hover .product-image img {
            transform: scale(1.05);
        }

        .product h3 {
            font-size: 16px;
            font-weight: 500;
            margin: 12px 0 6px;
        }

        .product a {
            text-decoration: none;
            color: inherit;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: purple;
            text-decoration: none;
            color: black;
        }

        .price {
            font-size: 14px;
            color: #333;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 12px;
            text-decoration: none;
            border: 1px solid #ddd;
            color: #555;
            font-size: 14px;
        }

        .pagination a.active {
            background-color: #555;
            color: #fff;
            border-color: #555;
        }

        header.header#mainHeader {
            background-color: white !important;
        }
    </style>
</head>

<body>
    <?php require_once("inc/header.php"); ?>

    <div class="main-content">
        <div class="products-section">
            <!-- 동적 제목 -->
            <div class="sale-title">
                <?= htmlspecialchars($decoded_term) ?> 시리즈
            </div>

            <!-- 페이지네이션 링크 수정 -->
            <a href="?item_name=<?= urlencode($search_term) ?>&page=<?= $i ?>&sort=<?= $sort ?>">

                <!-- 필터 섹션 -->
                <div class="filter-section">
                    <?php foreach ($allowed_sorts as $key => $col): ?>
                        <a href="?sort=<?= $key ?>"
                            class="<?= ($sort === $key) ? 'active-filter' : '' ?>">
                            <?= ['new' => '신상품', 'name' => '상품명', 'low' => '낮은가격', 'high' => '높은가격'][$key] ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- 상품 목록 -->
                <div class="products-container_f">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="product">
                                <a href="product_detail.php?item_id=<?= $row['item_id'] ?>">
                                    <div class="product-image">
                                        <img src="<?= htmlspecialchars($row['image_url'] ?? 'images/default.jpg') ?>"
                                            alt="<?= htmlspecialchars($row['item_name']) ?>"
                                            loading="lazy">
                                    </div>
                                    <h3><?= htmlspecialchars($row['item_name']) ?></h3>
                                    <p class="price"><?= number_format($row['price']) ?>원</p>
                                    <?php if (!is_null($row['price'])): ?>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="no-items">등록된 상품이 없습니다.</p>
                    <?php endif; ?>
                </div>
                <!-- 페이지네이션 -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?= $i ?>&sort=<?= $sort ?>"
                                class="<?= $i == $page ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
        </div>
    </div>
</body>

</html>
<?php require_once("inc/footer.php"); ?>
<?php $conn->close(); ?>