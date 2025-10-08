<?php
// 총 공지사항 개수
$total_notices = 12;
$notices_per_page = 5;
$total_pages = ceil($total_notices / $notices_per_page);

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;
if ($current_page > $total_pages) $current_page = $total_pages;

$offset = ($current_page - 1) * $notices_per_page;

// 공지사항 배열 (예시 데이터)
$notices = [
    ["title" => "[공지] 6월 배송 휴무 안내", "author" => "Luminous", "date" => "2025-05-25", "views" => 230],
    ["title" => "[신상품 안내] 아이폰 16 케이스 출시", "author" => "Luminous", "date" => "2025-05-23", "views" => 190],
    ["title" => "[이벤트 종료 안내] 봄맞이 할인 이벤트 종료", "author" => "Luminous", "date" => "2025-05-20", "views" => 165],
    ["title" => "[점검 안내] 시스템 정기 점검", "author" => "Luminous", "date" => "2025-05-18", "views" => 142],
    ["title" => "[배송 관련] 제주 및 도서산간 지역 추가 배송비 안내", "author" => "Luminous", "date" => "2025-05-15", "views" => 95],
    ["title" => "[안내] 고객센터 상담 시간 변경", "author" => "Luminous", "date" => "2025-05-12", "views" => 130],
    ["title" => "[공지] 사이트 이용약관 개정 안내", "author" => "Luminous", "date" => "2025-05-10", "views" => 80],
    ["title" => "[이벤트] 5월 신규회원 웰컴쿠폰 지급", "author" => "Luminous", "date" => "2025-05-08", "views" => 150],
    ["title" => "[공지] 개인정보 처리방침 개정 안내", "author" => "Luminous", "date" => "2025-05-06", "views" => 72],
    ["title" => "[배송 안내] 5월 어린이날 연휴 배송 일정", "author" => "Luminous", "date" => "2025-05-03", "views" => 110],
    ["title" => "[오류 안내] 일부 브라우저 주문 오류 해결", "author" => "Luminous", "date" => "2025-05-01", "views" => 97],
    ["title" => "[공지] 시스템 점검 완료 안내", "author" => "Luminous", "date" => "2025-04-30", "views" => 88],
];

$notices_display = array_slice($notices, $offset, $notices_per_page);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <title>공지사항</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            width: 100%;
            padding: 0 40px;
            margin: 80px auto;
            box-sizing: border-box;
        }

        .notice-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .notice-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .notice-item:hover {
            background-color: #fafafa;
        }

        .notice-title {
            font-size: 14px;
            font-weight: 500;
            flex: 1;
            text-align: left;
            word-break: break-word;
        }

        .notice-meta {
            font-size: 12px;
            color: #777;
            white-space: nowrap;
            text-align: right;
            margin-left: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .pagination a {
            padding: 8px 12px;
            text-decoration: none;
            border: 1px solid #ddd;
            color: #555;
            font-size: 14px;
            border-radius: 5px;
            transition: background 0.2s ease;
        }

        .pagination a.active {
            background-color: #555;
            color: #fff;
            border-color: #555;
        }

        .pagination a:hover {
            background-color: #f0f0f0;
        }

        .main-content h1 {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        header.header#mainHeader {
            background-color: white !important;
        }
    </style>
</head>

<body>
    <?php require_once("inc/header.php"); ?>
    <div class="main-content">
        <h1>공지사항</h1>
        <div class="notice-list">
            <?php foreach ($notices_display as $notice): ?>
                <div class="notice-item" onclick="location.href='notice_detail.php?title=<?= urlencode($notice['title']) ?>'">
                    <div class="notice-title">
                        <?= htmlspecialchars($notice['title']) ?>
                    </div>
                    <div class="notice-meta">
                        <?= htmlspecialchars($notice['author']) ?> | <?= htmlspecialchars($notice['date']) ?> | 조회수 <?= htmlspecialchars($notice['views']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <?php if ($current_page > 1): ?>
                <a href="?page=<?= $current_page - 1 ?>">&laquo; 이전</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= ($i === $current_page) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?= $current_page + 1 ?>">다음 &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
    <?php require_once("inc/footer.php"); ?>
</body>

</html>