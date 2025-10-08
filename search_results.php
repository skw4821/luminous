<?php
// db.php를 포함하여 DB 관련 함수 사용
require_once("inc/db.php");

$search_result = ''; // 초기화
$search_result_count = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_main'])) {
    // 사용자가 입력한 검색어 가져오기
    $search_query = $_POST['search_main'];

    // 검색 쿼리 (여러 테이블에서 content_name에서 검색어가 포함된 데이터 찾기)
    $query = "
        (SELECT 'contents' AS source, content_code, content_img, content_name, content_price FROM contents WHERE content_name LIKE ?)
        UNION
        (SELECT 'defuser' AS source, content_code, content_img, content_name, content_price FROM defuser WHERE content_name LIKE ?)
        UNION
        (SELECT 'female_perfume' AS source, content_code, content_img, content_name, content_price FROM female_perfume WHERE content_name LIKE ?)
        UNION
        (SELECT 'male_perfume' AS source, content_code, content_img, content_name, content_price FROM male_perfume WHERE content_name LIKE ?)
    ";

    // LIKE 쿼리를 위한 검색어에 '%' 추가
    $search_term = "%" . $search_query . "%"; // 부분 일치를 위해 앞뒤에 % 추가

    // db_select 함수 호출하여 검색 결과 가져오기
    $params = array($search_term, $search_term, $search_term, $search_term);
    $result = db_select($query, $params);

    // 결과 확인 후 출력
    if ($result) {
        $search_result = "<div class='products-container'>";
        foreach ($result as $row) {
            $search_result .= "<div class='product'>";
            
            // 각 테이블의 source 값에 맞는 상세 페이지 URL 생성
            if ($row['source'] == 'female_perfume') {
                $detail_url = "female_detail.php?content_code=" . $row['content_code'];
            } elseif ($row['source'] == 'male_perfume') {
                $detail_url = "male_detail.php?content_code=" . $row['content_code'];
            }elseif($row['source'] == 'defuser'){
                $detail_url = "product_detail.php?content_code=" . $row['content_code'];
            }else {
                $detail_url = "contents_detail.php?content_code=" . $row['content_code'];
            }

            // 링크 생성
            $search_result .= "<a href='" . $detail_url . "'>";
            $search_result .= "<img src='" . $row['content_img'] . "' alt='" . $row['content_name'] . "' />";
            $search_result .= "<h3>" . $row['content_name'] . "</h3>";
            $search_result .= "<p class='price'>" . number_format($row['content_price']) . "원</p>";
            $search_result .= "</a>";
            $search_result .= "</div>";
        }
        $search_result .= "</div>";
        $search_result_count = "<p>" . count($result) . "개의 상품이 검색되었습니다.</p>";
    } else {
        $search_result = "<p>검색 결과가 없습니다.</p>";
        $search_result_count = "";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>디퓨저 쇼핑몰</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .menu {
            background-color: #495057;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu .logo a {
            color: #fff;
            text-decoration: none;
            font-size: 1.5rem;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* 중앙 정렬 */
            gap: 20px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .product {
            text-align: center;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            height: 350px;
            width: 270px;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product:hover {
            transform: translateY(-10px);
        }

        .product img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .product a {
            text-decoration: none;
            color: #333;
        }

        .product h3 {
            font-size: 1.1rem;
            margin-top: 10px;
            color: #495057;
        }

        .price {
            color: #777;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        form {
            text-align: center;
            margin: 20px auto;
        }

        form input {
            padding: 10px;
            font-size: 1rem;
            width: 400px; /* 검색창을 가로로 길게 설정 */
            max-width: 100%; /* 화면 크기에 따라 꽉 차지 않도록 조절 */
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        form button {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #495057;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        form button:hover {
            background-color: #343a40;
        }

        h2 {
            font-size: 2rem;
            margin: 30px 0;
            text-align: center;
            color: #495057;
        }

        .search-results {
            text-align: center;
            margin-bottom: 40px;
        }

        .search-results p {
            font-size: 1rem;
            color: #777;
        }

        /* 경계선 스타일 추가 */
        .search-divider {
            border-top: 2px solid #ddd;
            margin: 20px 0; /* 경계선과 다른 콘텐츠 사이에 여백 추가 */
        }
    </style>
</head>

<body>
    <div class="menu">
        <div class="logo">
            <a href="index.php">DewAura</a>
        </div>
    </div>

    <!-- 검색 결과 출력 -->
    <div class="search-results">
        <h2>검색 결과</h2>
        <?php echo isset($search_result_count) ? $search_result_count : ''; ?>
    </div>

    <form method="POST" action="">
        <input type="text" name="search_main" placeholder="상품을 검색하세요..." required />
        <button type="submit">검색</button>
    </form>

    <!-- 검색창과 검색 결과 사이의 경계선 추가 -->
    <div class="search-divider"></div>

    <!-- 검색된 상품 품목들 출력 -->
    <div class="search-results">
        <?php echo isset($search_result) ? $search_result : ''; ?>
    </div>

</body>

</html>
