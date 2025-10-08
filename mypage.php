<?php
session_start();
require_once("inc/db.php");
require_once("inc/header.php");

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION['member_id'];
$member = db_select("SELECT nickname FROM Member WHERE member_id = ?", [$member_id]);
$member = is_array($member) && count($member) > 0 ? $member[0] : ['nickname' => '회원'];

$order_result = db_select("SELECT COUNT(*) as cnt, IFNULL(SUM(total_price), 0) as total FROM Orders WHERE member_id = ?", [$member_id]);
$order_data = is_array($order_result) ? $order_result[0] : ['cnt' => 0, 'total' => 0];

$order_states = ['입금전', '배송준비중', '배송중', '배송완료', '취소', '교환', '반품'];
$order_status_counts = [];

foreach ($order_states as $state) {
    $res = db_select("SELECT COUNT(*) as cnt FROM Orders WHERE member_id = ? AND order_status = ? AND order_date >= DATE_SUB(NOW(), INTERVAL 3 MONTH)", [$member_id, $state]);
    $order_status_counts[$state] = is_array($res) ? ($res[0]['cnt'] ?? 0) : 0;
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>마이 쇼핑</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Pretendard', sans-serif;
            background: #fff;
            color: #000;
            margin-top: 120px;
        }

        .container {
            max-width: 1600px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            margin-bottom: 60px;
            border: 1px solid #ddd;
            border-left: none;
            border-top: none;
        }

        .summary-cards .card {
            border-left: 1px solid #ddd;
            border-top: 1px solid #ddd;
            padding: 32px;
            text-align: center;
            background: #fff;
            box-sizing: border-box;
        }

        .card h3 {
            margin-bottom: 12px;
            font-size: 18px;
            font-weight: 600;
        }

        .card .value {
            font-size: 22px;
            font-weight: bold;
        }

        .flex {
            display: flex;
            gap: 40px;
            align-items: flex-start;
            margin-bottom: 60px;
        }

        .sidebar {
            width: 280px;
            padding-right: 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar h4 {
            margin-top: 0;
            margin-bottom: 16px;
            font-size: 18px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
            font-size: 15px;
        }

        .sidebar ul li a {
            color: #000;
            text-decoration: none;
        }

        .sidebar ul li a:hover {
            text-decoration: underline;
        }

        .content {
            flex: 1;
            padding-left: 20px;
        }

        .order-status {
            border: 1px solid #ddd;
            padding: 40px;
            margin-bottom: 40px;
            background: #fff;
        }

        .order-status h4 {
            margin-bottom: 32px;
            font-size: 20px;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            text-align: center;
            gap: 0;
            border-top: 1px solid #eee;
            border-left: 1px solid #eee;
            margin-bottom: 24px;
        }

        .status-grid .status {
            border-right: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 16px 0;
            font-size: 16px;
            background: #fafafa;
        }

        .bottom-status {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            text-align: center;
            border-top: 1px solid #ddd;
            margin-top: 24px;
            padding-top: 12px;
            font-size: 15px;
        }

        .bottom-status div {
            padding: 10px 0;
        }

        .sale-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 80px;
            text-align: center;
        }

        @media (max-width: 1024px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .flex {
                flex-direction: column;
                margin-bottom: 40px;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #ddd;
                margin-bottom: 20px;
                padding-right: 0;
            }

            .content {
                padding-left: 0;
            }

            .status-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sale-title">마이 쇼핑</div>

        <div class="summary-cards">
            <div class="card">
                <h3>안녕하세요. <?= htmlspecialchars($member['nickname']) ?> 님!</h3>
                <div class="value">방문을 환영합니다</div>
            </div>
            <div class="card">
                <h3>총 주문</h3>
                <div class="value"><?= number_format($order_data['total']) ?>원 (<?= $order_data['cnt'] ?>회)</div>
            </div>
            <div class="card">
                <h3>배송중인 주문</h3>
                <div class="value"><?= $order_status_counts['배송중'] ?>건</div>
            </div>
            <div class="card">
                <h3>완료된 주문</h3>
                <div class="value"><?= $order_status_counts['배송완료'] ?>건</div>
            </div>
        </div>

        <div class="flex">
            <div class="sidebar">
                <h4>나의 쇼핑정보</h4>
                <ul>
                    <li><a href="order_list.php">주문내역 조회</a></li>
                    <li><a href="cart.php">장바구니</a></li>
                </ul>

                <h4>나의 정보</h4>
                <ul>
                    <li><a href="edit_profile.php">회원 정보 수정</a></li>
                    <li><a href="change_password.php">비밀번호 변경</a></li>
                    <li><a href="logout.php">로그아웃</a></li>
                </ul>
            </div>

            <div class="content">
                <div class="order-status">
                    <h4>나의 주문처리 현황 <small>(최근 3개월 기준)</small></h4>
                    <div class="status-grid">
                        <?php foreach (['입금전', '배송준비중', '배송중', '배송완료'] as $state): ?>
                            <div class="status">
                                <strong><?= $order_status_counts[$state] ?></strong><br>
                                <?= $state ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="bottom-status">
                        <?php foreach (['취소', '교환', '반품'] as $state): ?>
                            <div>
                                <?= $state ?> : <?= $order_status_counts[$state] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php require_once("inc/footer.php"); ?>

</html>
