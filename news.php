<?php

// 뉴스 배열 (총 18개 예제)
$news = [
    ["news_code" => "news1", "news_img" => "img/news1.png", "news_title" => "브랜드 런칭 소식", "news_date" => "2025-05-01"],
    ["news_code" => "news2", "news_img" => "img/news2.png", "news_title" => "신제품 공개", "news_date" => "2025-06-10"],
    ["news_code" => "news3", "news_img" => "img/news3.png", "news_title" => "업계 어워드 수상", "news_date" => "2025-07-05"],
    ["news_code" => "news4", "news_img" => "img/news4.png", "news_title" => "CSR 활동 소식", "news_date" => "2025-09-20"],
    ["news_code" => "news5", "news_img" => "img/news5.png", "news_title" => "파트너십 체결", "news_date" => "2025-11-01"],
    ["news_code" => "news6", "news_img" => "img/news6.png", "news_title" => "연말 캠페인 발표", "news_date" => "2025-12-10"],
    ["news_code" => "news7", "news_img" => "img/news7.png", "news_title" => "새해 인사", "news_date" => "2026-01-01"],
    ["news_code" => "news8", "news_img" => "img/news8.png", "news_title" => "봄 시즌 미리보기", "news_date" => "2026-02-20"],
    ["news_code" => "news9", "news_img" => "img/news9.png", "news_title" => "리뉴얼 안내", "news_date" => "2026-04-01"],
    ["news_code" => "news10", "news_img" => "img/news10.png", "news_title" => "여름 캠페인 공개", "news_date" => "2026-06-15"],
    ["news_code" => "news11", "news_img" => "img/news11.png", "news_title" => "고객 감사 이벤트", "news_date" => "2026-07-01"],
    ["news_code" => "news12", "news_img" => "img/news12.png", "news_title" => "글로벌 진출 발표", "news_date" => "2026-08-20"],
    ["news_code" => "news13", "news_img" => "img/news13.png", "news_title" => "브랜드 컬래버 소식", "news_date" => "2026-09-10"],
    ["news_code" => "news14", "news_img" => "img/news14.png", "news_title" => "디자인 어워드 수상", "news_date" => "2026-10-05"],
    ["news_code" => "news15", "news_img" => "img/news15.png", "news_title" => "연말 정산 공지", "news_date" => "2026-11-30"],
    ["news_code" => "news16", "news_img" => "img/news16.png", "news_title" => "겨울 캠페인 시작", "news_date" => "2026-12-10"],
    ["news_code" => "news17", "news_img" => "img/news17.png", "news_title" => "기부 캠페인 진행", "news_date" => "2027-01-15"],
    ["news_code" => "news18", "news_img" => "img/news18.png", "news_title" => "봄 신상품 런칭", "news_date" => "2027-03-01"]
];

// 한 페이지에 보여줄 뉴스 수
$news_per_page = 9;
$total_news = count($news);
$total_pages = ceil($total_news / $news_per_page);

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $news_per_page;

// 현재 페이지에 해당하는 뉴스만 추출
$news_display = array_slice($news, $offset, $news_per_page);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>뉴스</title>
    <style>
        header.header#mainHeader {
            background-color: white !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
            text-align: center;
        }

        .main-content {
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .sale-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .news-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 30px;
            justify-content: center;
        }

        .news-item {
            background: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            text-align: left;
            padding: 15px;
            transition: box-shadow 0.2s ease;
        }

        .news-item:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .news-image img {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .news-title {
            font-size: 18px;
            font-weight: 600;
            margin: 12px 0;
        }

        .news-date {
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }

        .news-item a {
            text-decoration: none;
            color: inherit;
        }

        .news-container p {
            color: #666;
            font-size: 12px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 30px;
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
    </style>
</head>
<body>
    <?php require_once("inc/header.php"); ?>

    <div class="main-content">
        <div class="sale-title">뉴스</div>

        <div class="news-container">
            <?php foreach ($news_display as $item): ?>
                <div class="news-item">
                    <a href="news_detail.php?news_code=<?php echo $item['news_code']; ?>">
                        <div class="news-image">
                            <img src="<?php echo $item['news_img']; ?>" alt="<?php echo $item['news_title']; ?>">
                        </div>
                        <h3 class="news-title"><?php echo $item['news_title']; ?></h3>
                        <p>Luminous <?php echo date("Y-m-d", strtotime($item['news_date'])); ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <a href="?page=1">&laquo;</a>
            <a href="?page=<?php echo max(1, $current_page - 1); ?>">&lt;</a>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $current_page ? 'active' : ''); ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <a href="?page=<?php echo min($total_pages, $current_page + 1); ?>">&gt;</a>
            <a href="?page=<?php echo $total_pages; ?>">&raquo;</a>
        </div>
    </div>

    <?php require_once("inc/footer.php"); ?>
</body>
</html>
