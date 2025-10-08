<?php
session_start(); // 반드시 첫 줄에 위치
require_once("inc/header.php");
// 이후 코드
?>
<?php
// 총 이벤트 개수 (예제에서는 9개로 설정)
$total_events = 9;
$events_per_page = 3;
$total_pages = ceil($total_events / $events_per_page);

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $events_per_page;

// 기본 이벤트 목록 배열 (DB 없이 테스트용)
$events = [
    ["event_code" => "event1", "event_img" => "img/event1.jpg", "event_title" => "봄맞이 할인 이벤트", "event_start" => "2025-05-01", "event_end" => "2025-05-15"],
    ["event_code" => "event2", "event_img" => "img/event2.jpg", "event_title" => "여름 특가 프로모션", "event_start" => "2025-06-01", "event_end" => "2025-06-30"],
    ["event_code" => "event3", "event_img" => "img/event3.jpg", "event_title" => "벚꽃맞이 셀카봉 이벤트", "event_start" => "2025-04-10", "event_end" => "2025-04-25"],
    ["event_code" => "event4", "event_img" => "img/event4.jpg", "event_title" => "가을 맞이 특별 행사", "event_start" => "2025-09-01", "event_end" => "2025-09-15"],
    ["event_code" => "event5", "event_img" => "img/event5.jpg", "event_title" => "윈터 세일 이벤트", "event_start" => "2025-11-10", "event_end" => "2025-11-30"],
    ["event_code" => "event6", "event_img" => "img/event6.jpg", "event_title" => "크리스마스 한정 프로모션", "event_start" => "2025-12-20", "event_end" => "2025-12-25"],
    ["event_code" => "event7", "event_img" => "img/event7.jpg", "event_title" => "신년 맞이 이벤트", "event_start" => "2026-01-01", "event_end" => "2026-01-15"],
    ["event_code" => "event8", "event_img" => "img/event8.jpg", "event_title" => "발렌타인데이 특별 행사", "event_start" => "2026-02-10", "event_end" => "2026-02-14"],
    ["event_code" => "event9", "event_img" => "img/event9.jpg", "event_title" => "봄맞이 리뉴얼 이벤트", "event_start" => "2026-04-01", "event_end" => "2026-04-15"]
];

// 현재 페이지에 해당하는 이벤트 가져오기
$events_display = array_slice($events, $offset, $events_per_page);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>이벤트</title>
    <style>
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

        /* 이벤트 목록 반응형 조정 */
        .event-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            /* 한 줄에 3개, 가능하면 자동 조정 */
            gap: 30px;
            justify-content: center;
        }

        .event-item {
            background: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            text-align: left;
            /* 왼쪽 정렬 적용 */
            padding: 15px;
            transition: box-shadow 0.2s ease;
        }

        .event-item:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .event-image img {
            width: 100%;
            /* 이미지 크기 확대 */
            height: auto;
            display: block;
            margin: 0 auto;
            /* 이미지 가운데 정렬 */
        }

        .event-title {
            font-size: 18px;
            /* 글자 크기 약간 키움 */
            font-weight: 600;
            margin: 12px 0;
        }

        .event-date {
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }

        /* 하이퍼링크 스타일 제거 */
        .event-item a {
            text-decoration: none;
            color: inherit;
        }

        /* 페이지네이션 */
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
        .event-container p{
            color :#666;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <?php require_once("inc/header.php"); ?>
    <div class="main-content">
        <div class="sale-title">프로모션</div>

        <!-- 이벤트 목록 -->
        <div class="event-container">
            <?php
            foreach ($events_display as $event) {
                echo '<div class="event-item">';
                echo '<a href="event_detail.php?event_code=' . $event['event_code'] . '">';
                echo '<div class="event-image"><img src="' . $event["event_img"] . '" alt="' . $event["event_title"] . '"></div>';
                echo '<h3 class="event-title">' . $event["event_title"] . '</h3>';
                echo '<p>'. "Luminous " . date("Y-m-d", strtotime($event["event_start"])). '</p>';
                echo '</a>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- 페이지네이션 -->
        <div class="pagination">
            <?php
            echo '<a href="?page=1">&laquo;</a>'; // 첫 페이지
            echo '<a href="?page=' . max(1, $current_page - 1) . '">&lt;</a>'; // 이전 페이지

            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="?page=' . $i . '" class="' . ($i == $current_page ? "active" : "") . '">' . $i . '</a>';
            }

            echo '<a href="?page=' . min($total_pages, $current_page + 1) . '">&gt;</a>'; // 다음 페이지
            echo '<a href="?page=' . $total_pages . '">&raquo;</a>'; // 마지막 페이지
            ?>
        </div>
    </div>

</body>

</html>
<?php require_once("inc/footer.php"); ?>