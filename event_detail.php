<?php
session_start(); // 반드시 첫 줄에 위치
require_once("inc/header.php");
// 이후 코드
?>
<?php
$event_code = isset($_GET['event_code']) ? $_GET['event_code'] : '';

// 이벤트별 정보 배열로 관리 (확장/유지보수 용이)
$events = [
    'event1' => [
        'title' => "루미너스 SPRING COLLECTION",
        'subtitle' => "봄맞이 신상 출시! 최대 30% 할인",
        'desc' => "
            <ul style='line-height:2; margin:0 0 24px 0; padding-left:18px;'>
                <li>2025년 봄 신상 케이스 & 악세서리 단독 공개</li>
                <li>전품목 30% 할인 + 무료배송</li>
                <li>포토후기 작성 시 벚꽃 키링 증정</li>
            </ul>
        ",
        'period' => "이벤트 기간: 2025.03.10 ~ 2025.04.10",
        'notice' => "* 사은품은 한정 수량으로 조기 소진될 수 있습니다.",
        'img' => "/Luminous/img/event1.jpg"
    ],
    'event2' => [
        'title' => "루미너스 SUMMER SPECIAL SALE",
        'subtitle' => "한여름을 더욱 특별하게! 최대 50% 할인 + 사은품 증정",
        'desc' => "
            <ul style='line-height:2; margin:0 0 24px 0; padding-left:18px;'>
                <li>2025년 여름 한정, 인기 케이스 & 악세서리 초특가!</li>
                <li>아이폰 · 갤럭시 · 에어팟 · 애플워치 케이스 전품목 할인</li>
                <li>베스트셀러 최대 50% OFF + 2만원 이상 구매 시 썸머 키링 증정</li>
                <li>포토후기 우수작 선정 시 삼각대 증정</li>
                <li>신상 컬러, 한정판 디자인 단독 공개</li>
                <li>무료배송, 무이자 할부, 오늘만 추가 쿠폰 지급!</li>
            </ul>
        ",
        'period' => "이벤트 기간: 2025.06.15 ~ 2025.07.15",
        'notice' => "* 사은품/삼각대는 한정 수량으로 조기 소진될 수 있습니다.",
        'img' => "/Luminous/img/event2.jpg"
    ],
    'event3' => [
        'title' => "벚꽃 찍고 인생 고점 찍자!",
        'subtitle' => "루미너스 벚꽃인증 프로모션",
        'desc' => "
            <ul style='line-height:2; margin:0 0 24px 0; padding-left:18px;'>
                <li>구매 후기에 벚꽃사진과 함께 상품 사인을 올려주시면 추첨을 통해 루미너스 삼각대를 보내드립니다</li>
                <li>3만원 이상 구매 시 가죽 카드지갑 증정</li>
                <li>리뷰 작성 시 추가 적립금 지급</li>
            </ul>
        ",
        'period' => "이벤트 기간: 2025.04.15 ~ 2025.04.30",
        'notice' => "* 사은품은 한정 수량입니다.",
        'img' => "/Luminous/img/event3.jpg"
    ],
    'event4' => [
        'title' => "루미너스 WINTER FESTA",
        'subtitle' => "겨울 한정 컬렉션 & 선물 이벤트",
        'desc' => "
            <ul style='line-height:2; margin:0 0 24px 0; padding-left:18px;'>
                <li>겨울 한정 케이스/악세서리 35% 할인</li>
                <li>구매고객 전원 핸드워머 증정</li>
                <li>포토후기 1등에 에어팟 증정</li>
            </ul>
        ",
        'period' => "이벤트 기간: 2025.12.01 ~ 2025.12.31",
        'notice' => "* 사은품은 한정 수량입니다.",
        'img' => "/Luminous/img/event4.jpg"
    ],
    'event5' => [
        'title' => "루미너스 NEW YEAR BIG SALE",
        'subtitle' => "새해맞이 전품목 최대 60% 할인",
        'desc' => "
            <ul style='line-height:2; margin:0 0 24px 0; padding-left:18px;'>
                <li>2026년 신상 케이스/악세서리 최초 공개</li>
                <li>전품목 최대 60% 할인 + 무료배송</li>
                <li>구매고객 추첨 10명에 최신 스마트워치 증정</li>
            </ul>
        ",
        'period' => "이벤트 기간: 2026.01.01 ~ 2026.01.15",
        'notice' => "* 경품은 1월 20일 개별 안내 예정입니다.",
        'img' => "/Luminous/img/event5.jpg"
    ],
    'event6' => [
        'title' => "루미너스 고객 감사 페스티벌",
        'subtitle' => "누적 구매고객 특별 사은 이벤트",
        'desc' => "
            <ul style='line-height:2; margin:0 0 24px 0; padding-left:18px;'>
                <li>누적 구매 5회 이상 고객 100% 사은품 증정</li>
                <li>이벤트 기간 내 신규가입 시 5천원 쿠폰 추가 지급</li>
                <li>구매왕 1명에 아이패드 증정</li>
            </ul>
        ",
        'period' => "이벤트 기간: 2026.02.01 ~ 2026.02.29",
        'notice' => "* 사은품/경품은 3월 5일 이후 순차 발송됩니다.",
        'img' => "/Luminous/img/event6.jpg"
    ],
];

// 이벤트 정보 가져오기
if (array_key_exists($event_code, $events)) {
    $event = $events[$event_code];
} else {
    $event = [
        'title' => "이벤트를 찾을 수 없습니다.",
        'subtitle' => "",
        'desc' => "<p>잘못된 접근입니다.</p>",
        'period' => "",
        'notice' => "",
        'img' => ""
    ];
}
?>

<main>
    <div style="max-width:900px; margin:60px auto 40px auto; width:95vw;">
        <?php if ($event['img']): ?>
            <img src="<?= $event['img'] ?>" alt="<?= $event['title'] ?>" style="width:100%;max-width:900px;display:block;border-radius:24px;box-shadow:0 8px 32px rgba(80,60,120,0.12);margin-bottom:32px;">
        <?php endif; ?>

        <h1 style="font-size:2.2rem; font-weight:800; color:#2a3a60; margin-bottom:18px; letter-spacing:-0.02em;">
            <?= $event['title'] ?>
        </h1>
        <?php if ($event['subtitle']): ?>
            <div style="font-size:1.15rem; color:#4a90e2; font-weight:600; margin-bottom:18px;">
                <?= $event['subtitle'] ?>
            </div>
        <?php endif; ?>
        <div style="font-size:1.05rem; color:#222; margin-bottom:18px;">
            <?= $event['desc'] ?>
        </div>
        <?php if ($event['period']): ?>
            <div style="font-size:1.03rem; color:#888; margin-bottom:16px;">
                <?= $event['period'] ?>
            </div>
        <?php endif; ?>
        <?php if ($event['notice']): ?>
            <div style="font-size:0.96rem; color:#e67e22; margin-bottom:0;">
                <?= $event['notice'] ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once("inc/footer.php"); ?>