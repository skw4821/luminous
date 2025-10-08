<?php
session_start();
require_once("inc/db.php");
require_once("inc/header.php");

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION['member_id'];

$start_date = $_GET['start_date'] ?? date("Y-m-d", strtotime("-1 month"));
$end_date = $_GET['end_date'] ?? date("Y-m-d");
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$items_per_page = 5;
$offset = ($page - 1) * $items_per_page;

// 전체 주문 수 계산
$total_orders = db_select("
    SELECT COUNT(*) AS total
    FROM Orders
    WHERE member_id = ? AND order_date BETWEEN ? AND ?
", [$member_id, $start_date, $end_date])[0]['total'];

$total_pages = max(1, ceil($total_orders / $items_per_page)); // 항상 최소 1페이지는 보이도록 설정

// Item 테이블을 JOIN 하여 상품명도 가져오기
$orders = db_select("
    SELECT Orders.order_id, Orders.order_date, Orders.total_price, Orders.order_status, Item.item_name AS item_name

    FROM Orders
    JOIN Item ON Orders.item_id = Item.item_id
    WHERE Orders.member_id = ? AND Orders.order_date BETWEEN ? AND ?
    ORDER BY Orders.order_date DESC
", [$member_id, $start_date, $end_date]);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>주문내역 조회</title>
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

        .flex {
            display: flex;
            gap: 40px;
            align-items: flex-start;
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

        h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        form {
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .date-buttons {
            margin-bottom: 10px;
            display: flex;
            gap: 10px;
        }

        .date-buttons button {
            padding: 0 16px;
            height: 36px;
            line-height: 36px;
            background: #000;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            min-width: 80px;
            text-align: center;
        }

        input[type="date"] {
            height: 36px;
            padding: 0 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            vertical-align: middle;
        }

        .date-buttons button:hover {
            background: #333;
        }

        button[type="submit"] {
            padding: 8px 16px;
            background: #000;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 60px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 15px;
        }

        th {
            background-color: #f9f9f9;
        }

        th:nth-child(1) {
            width: 100px;
            /* 주문번호 열 폭 좁힘 */
        }

        .no-orders {
            text-align: center;
            padding: 40px;
            font-size: 16px;
            border: 1px solid #eee;
            background: #fafafa;
        }

        @media (max-width: 1024px) {
            .flex {
                flex-direction: column;
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

            table th,
            table td {
                font-size: 14px;
                padding: 8px;
            }
        }

        .sale-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 80px;
            text-align: center;
        }

        .pagination a {
            padding: 6px 12px;
            margin: 0 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            /* 밑줄 제거 */
            color: #000;
            cursor: pointer;
        }

        .pagination a:hover {
            background-color: #eee;
        }

        .pagination a.active {
            font-weight: 600;
            background-color: #000;
            color: #fff;
            text-decoration: none;
            /* 밑줄 제거 */
        }
    </style>
</head>

<body>
    <div class="sale-title">주문내역 조회</div>
    <div class="container">
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
                <form method="GET">
                    <div class="date-buttons">
                        <button type="button" onclick="setRange(1)">1개월</button>
                        <button type="button" onclick="setRange(3)">3개월</button>
                        <button type="button" onclick="setRange(6)">6개월</button>
                        <button type="button" onclick="setRange(12)">1년</button>
                    </div>

                    <label for="start_date"></label>
                    <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($start_date) ?>">
                    <label for="end_date"> ~ </label>
                    <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($end_date) ?>">
                    <button type="submit">조회</button>
                </form>

                <?php if (!$orders || count($orders) === 0): ?>
                    <div class="no-orders">해당 기간에 주문내역이 없습니다.</div>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>주문번호</th>
                                <th>상품명</th>
                                <th>주문일자</th>
                                <th>총금액</th>
                                <th>주문상태</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                                    <td><?= htmlspecialchars($order['item_name']) ?></td>
                                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                                    <td><?= number_format($order['total_price']) ?>원</td>
                                    <td><?= htmlspecialchars($order['order_status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- ✅ 여기에 페이지네이션 -->
                    <div style="text-align: center; margin-top: 20px;">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <?php
                            $query = $_GET;
                            $query['page'] = $i;
                            $link = '?' . http_build_query($query);
                            $isActive = $i === $page;
                            ?>
                            <a href="<?= $link ?>"
                                style="
                                display:inline-block;
                                padding:8px 12px;
                                margin:0 4px;
                                border:1px solid #000;
                                border-radius:4px;
                                font-size:14px;
                                text-decoration: none;
                        <?= $isActive ? 'background:#000;color:#fff;' : 'background:#fff;color:#000;' ?>
                     ">
                                <?= $i ?>
                            </a>

                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script>
        function setRange(months) {
            const end = new Date();
            const start = new Date();
            start.setMonth(start.getMonth() - months);

            document.getElementById("start_date").value = start.toISOString().slice(0, 10);
            document.getElementById("end_date").value = end.toISOString().slice(0, 10);
        }
    </script>
</body>

<?php require_once("inc/footer.php"); ?>

</html>