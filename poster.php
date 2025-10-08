<?php
// 포스터 이미지 목록 (테스트용)
$posters = [
    "img/poster1.png",
    "img/poster2.png",
    "img/poster3.png",
    "img/poster4.png",
    "img/poster5.png",
    "img/poster6.png",
    "img/poster7.png",
    "img/poster8.png",
    "img/poster9.png"
];
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <title>포스터 갤러리</title>
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

        /* 이벤트 목록 스타일 유지하며 포스터 이미지 나열 */
        .event-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 30px;
            justify-content: center;
        }

        .event-item {
            background: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            text-align: left;
            padding: 15px;
            transition: box-shadow 0.2s ease;
            cursor: pointer;
        }

        .event-item:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .event-image img {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <?php require_once("inc/header.php"); ?>

    <div class="main-content">
        <div class="sale-title">포스터 갤러리</div>

        <div class="event-container">
            <?php
            foreach ($posters as $poster) {
                echo '<div class="event-item">';
                echo '<div class="event-image">';
                echo '<img src="' . htmlspecialchars($poster) . '" alt="포스터 이미지">';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <?php require_once("inc/footer.php"); ?>
</body>

</html>
