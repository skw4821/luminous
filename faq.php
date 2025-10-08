
<?php
session_start(); // 반드시 첫 줄에 위치
require_once("inc/header.php");
// 이후 코드


// 총 FAQ 개수 (예제 데이터)
$total_faqs = 12;
$faqs_per_page = 5;
$total_pages = ceil($total_faqs / $faqs_per_page);

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;
if ($current_page > $total_pages) $current_page = $total_pages;

$offset = ($current_page - 1) * $faqs_per_page;

// FAQ 목록 배열 (DB 없이 테스트용)
$faqs = [
    ["title" => "회원가입은 어떻게 하나요?", "author" => "Luminous", "date" => "2025-05-01", "views" => 120],
    ["title" => "비밀번호를 잊어버렸어요", "author" => "Luminous", "date" => "2025-05-03", "views" => 98],
    ["title" => "상품 반품 절차가 궁금해요", "author" => "Luminous", "date" => "2025-05-05", "views" => 75],
    ["title" => "배송 기간은 얼마나 걸리나요?", "author" => "Luminous", "date" => "2025-05-10", "views" => 150],
    ["title" => "포인트 적립 방법이 궁금해요", "author" => "Luminous", "date" => "2025-05-12", "views" => 60],
    ["title" => "회원 탈퇴는 어떻게 하나요?", "author" => "Luminous", "date" => "2025-05-15", "views" => 45],
    ["title" => "결제 수단에는 어떤 게 있나요?", "author" => "Luminous", "date" => "2025-05-18", "views" => 110],
    ["title" => "쿠폰 사용 방법을 알려주세요", "author" => "Luminous", "date" => "2025-05-20", "views" => 90],
    ["title" => "이벤트 참여 조건은?", "author" => "Luminous", "date" => "2025-05-22", "views" => 70],
    ["title" => "상품 문의는 어떻게 하나요?", "author" => "Luminous", "date" => "2025-05-25", "views" => 85],
    ["title" => "배송지 변경은 가능한가요?", "author" => "Luminous", "date" => "2025-05-28", "views" => 55],
    ["title" => "회원 등급 기준이 어떻게 되나요?", "author" => "Luminous", "date" => "2025-05-30", "views" => 65],
];

// 현재 페이지에 해당하는 FAQ만 추출
$faqs_display = array_slice($faqs, $offset, $faqs_per_page);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <title>FAQ 게시판</title>
    <style>
        /* 기본 설정 */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            
        }

        /* 메인 콘텐츠 */
        .main-content {
            width: 100%;
            padding: 0 40px;
            margin: 80px auto;
            box-sizing: border-box;
        }

        /* FAQ 리스트 감싸는 컨테이너 */
        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* 각각의 FAQ 항목 */
        .faq-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .faq-item:hover {
            background-color: #fafafa;
        }

        /* 제목 부분 */
        .faq-title {
            display: flex;
            align-items: center;
            font-size: 12px;
            font-weight: 500;
            flex: 1;
            text-align: left;
            word-break: break-word;
        }


        /* 작성자, 날짜, 조회수 정보 */
        .faq-meta {
            font-size: 12px;
            color: #777;
            white-space: nowrap;
            text-align: right;
            margin-left: 20px;
        }

        /* 페이지네이션 */
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

        /* FAQ 제목 가운데 정렬 */
        .main-content h1 {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .faq-label {
            font-size: 12px;
            font-weight: 500;
            color: #aaa;
            margin-right: 25px;
        }
        header.header#mainHeader {
            background-color: white !important;
        }
    </style>
</head>

<body>
    <?php require_once("inc/header.php"); ?>
    <div class="main-content">
        <h1>FAQ</h1>
        <div class="faq-list">
            <?php foreach ($faqs_display as $faq): ?>
                <div class="faq-item" onclick="location.href='faq_detail.php?title=<?= urlencode($faq['title']) ?>'">
                    <div class="faq-title">
                        <span class="faq-label">FAQ</span>
                        <?= htmlspecialchars($faq['title']) ?>
                    </div>
                    <div class="faq-meta">
                        <?= htmlspecialchars($faq['author']) ?> | <?= htmlspecialchars($faq['date']) ?> | 조회수 <?= htmlspecialchars($faq['views']) ?>
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