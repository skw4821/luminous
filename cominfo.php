
<?php
session_start(); // 반드시 첫 줄에 위치
require_once("inc/header.php");
// 이후 코드
?>
<?php
$history = [
    "2000년: Luminous 설립",
    "2003년: 첫 폴더폰 케이스 디자인 특허 등록",
    "2007년: 프리미엄 라인 'Luminous Luxe' 출시",
    "2010년: 국내 주요 백화점 입점 시작",
    "2013년: 글로벌 시장 진출 (일본, 미국)",
    "2016년: 무선 충전 대응 케이스 특허 취득",
    "2018년: 온라인 공식 쇼핑몰 런칭",
    "2020년: 친환경 소재 제품군 'EcoGuard' 출시",
    "2022년: 아시아 디자인 어워드 수상",
    "2024년: 누적 판매 1,000만 개 돌파"
];
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>Luminous 연혁</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 폰트 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Noto Sans KR', sans-serif;
            background-color: #0d0f0e;
            color: #fff;
        }

        .nav-item {
            color: #000000;
        }

        .history-section {
            position: relative;
            width: 100%;
            height: 100vh;
            background-image: url('img/cominfor1.jpg');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: left center;
            background-color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .history-text {
            text-align: left;
            max-width: 600px;
            padding: 30px;
        }

        .history-text h2 {
            font-size: 2em;
            margin-bottom: 20px;
            font-weight: 700;
            color: #ffffff;
        }

        .history-text ul {
            list-style: disc;
            padding-left: 20px;
        }

        .history-text li {
            font-size: 1.2em;
            margin-bottom: 15px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .history-text li.show {
            opacity: 1;
            transform: translateY(0);
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            background-color: #111;
            color: #fff;
            padding: 80px 5%;
            gap: 40px;
            flex-wrap: wrap;
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .info-section.show {
            opacity: 1;
            transform: translateY(0);
        }

        .info-box {
            flex: 1 1 45%;
            background-color: #1a1a1a;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }

        .info-box h2 {
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .info-box p {
            font-size: 1.2em;
            line-height: 1.8;
        }

        @media (max-width: 768px) {
            .history-section {
                background-size: cover;
                background-position: center top;
                flex-direction: column;
                padding: 20px;
            }

            .history-text {
                padding: 20px;
                text-align: center;
            }

            .info-section {
                flex-direction: column;
                padding: 40px 20px;
            }

            .info-box {
                flex: 1 1 100%;
                margin-bottom: 30px;
                text-align: center;
            }

            .info-box h2 {
                font-size: 1.5em;
            }

            .info-box p {
                font-size: 1em;
            }
        }
    </style>
</head>

<body>
    <div class="history-section">
        <div class="history-text">
            <h2>Luminous Company history</h2>
            <ul id="historyList">
                <?php foreach ($history as $item): ?>
                    <li><?= $item ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="info-section">
        <div class="info-box">
            <h2>오시는 길</h2>
            <p>
                서울특별시 강남구 테헤란로 123<br>
                2호선 삼성역 5번 출구에서 도보 5분<br>
                Tel: 02-1234-5678<br>
                Email: contact@luminous.com
            </p>
        </div>
        <div class="info-box">
            <h2>회사 이념</h2>
            <p>
                우리는 혁신적인 디자인과 지속 가능한 기술을 통해<br>
                고객의 삶을 더욱 풍요롭고 아름답게 만드는 것을 목표로 합니다.<br>
                ‘가치 있는 변화’를 만들어가는 것이 Luminous의 철학입니다.
            </p>
        </div>
    </div>

    <script>
        // 연혁 애니메이션
        window.addEventListener('DOMContentLoaded', () => {
            const items = document.querySelectorAll('#historyList li');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('show');
                }, 100 * index);
            });
        });

        // 스크롤 시 info-section 등장
        function revealOnScroll() {
            const section = document.querySelector('.info-section');
            const windowHeight = window.innerHeight;

            if (section.getBoundingClientRect().top < windowHeight - 100) {
                section.classList.add('show');
            }
        }

        window.addEventListener('scroll', revealOnScroll);
        window.addEventListener('DOMContentLoaded', revealOnScroll);
    </script>
</body>
</html>