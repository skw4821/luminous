<?php

if (session_status() === PHP_SESSION_NONE)
session_start();    
$currentPage = basename($_SERVER['PHP_SELF']);
$currentPage = $currentPage ?? '';
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메뉴 효과</title>
    <?php
    if (
        $currentPage !== 'product.php' && $currentPage !== 'login.php'
        && $currentPage !== 'product_detail.php' && $currentPage !== 'event.php'
        && $currentPage !== 'event.php' && $currentPage !== 'end_event.php' && $currentPage !== 'news.php' && $currentPage !== 'sign_up.php'
    ) {
        echo '<link rel="stylesheet" href="css/style.css">';
    }
    ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding-top: 80px;
            background: #f5f5f5;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background: rgba(255, 255, 255, 0);
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s, box-shadow 0.3s;
            z-index: 1000;
        }

        .header.active,
        .header:hover {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #222;
            text-decoration: none;
            transition: color 0.3s;
        }

        .header.active .logo,
        .header:hover .logo {
            color: #111;
        }

        .nav {
            display: flex;
            gap: 100px;
            position: relative;
            z-index: 10;
        }

        .nav-item {
            position: relative;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            color: #222;
            padding: 20px 0 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: color 0.3s;
        }

        .header.active .nav-item,
        .header:hover .nav-item {
            color: #111;
        }

        .red-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: red;
            margin-bottom: 6px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .nav-item.active .red-dot,
        .nav-item:hover .red-dot,
        .nav-item:focus-within .red-dot {
            opacity: 1;
        }

        /* -------------------- 수정된 서브메뉴 스타일 -------------------- */
        .submenu {
            position: fixed;
            top: 80px;
            left: 0;
            width: 100vw;
            min-width: 100vw;
            background: rgba(255, 255, 255, 0.7);
            /* 헤더보다 더 투명 */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: none;
            flex-direction: column;
            align-items: center;
            padding: 32px 0 24px 0;
            z-index: 100;
            border-radius: 0;
            user-select: none;
        }

        .submenu a {
            display: block;
            padding: 12px 0;
            color: #222;
            font-size: 18px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            width: 200px;
            margin: 0 auto;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .submenu a:hover,
        .submenu a:focus {
            background: #eee;
            outline: none;
        }

        /* nav-item에 마우스 올리거나 포커스 있을 때 서브메뉴 표시 */
        .nav-item:hover .submenu,
        .nav-item:focus-within .submenu {
            display: flex;
        }

        .header-right {
            display: flex;
            gap: 20px;
        }

        .login-header-right {
            display: flex;
        }

        .header-right button {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #222;
            transition: color 0.3s;
        }

        .header.active .header-right button,
        .header:hover .header-right button {
            color: #111;
        }

        .search-container-main {
            position: relative;
        }

        .search-box {
            position: absolute;
            top: 100%;
            /* 아이콘 바로 아래 */
            right: 0;
            margin-top: 8px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 200px;
            z-index: 1000;
        }

        .search-icon {
            margin-top: 3px;
            width: 25px;
            height: 25px;
            cursor: pointer;
            transition: transform 0.2s;
            object-fit: contain;
            /* 아이콘 비율 유지 */
        }

        .search-box input {
            width: 100%;
            padding: 6px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        .user-icon:hover {
            transform: scale(1.05);
        }

        /* 사용자 아이콘 스타일 */
        .user-menu {
            position: relative;
            /* 기준 위치 */
            display: flex;
            align-items: center;
        }

        .user-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.2s;
            display: block;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            /* 아이콘 바로 아래 */
            left: 50%;
            /* 아이콘의 가로 중앙 기준 */
            transform: translateX(-50%);
            /* 왼쪽으로 절반 이동해서 중앙 정렬 */
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: none;
            flex-direction: column;
            min-width: 140px;
            z-index: 999;
        }


        .user-dropdown a {
            padding: 10px 16px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.2s;
        }

        .user-dropdown a:hover {
            background: #f0f0f0;
        }

        /* hover 시 드롭다운 보이기 */
        .user-menu:hover .user-dropdown,
        .user-menu:focus-within .user-dropdown {
            display: flex;
        }


        @media (max-width: 900px) {

            .header,
            .header.active,
            .header:hover {
                background: #fff !important;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            }

            .logo,
            .nav-item,
            .header-right button {
                color: #111 !important;
            }

            .nav {
                gap: 20px;
            }

            .nav-item {
                font-size: 16px;
                padding: 15px 0;
            }

            .submenu {
                min-width: 140px;
                width: 100vw;
                padding: 24px 0 18px 0;
            }

            .submenu a {
                font-size: 16px;
                width: 140px;
            }



        }
    </style>
</head>

<body>
    <header class="header" id="mainHeader" tabindex="0">
        <a href="index.php" class="logo">Luminous</a>
        <nav class="nav" role="menubar">
            <div class="nav-item" role="menuitem" tabindex="0">
                <div class="red-dot"></div>
                브랜드
                <div class="submenu" role="menu" aria-label="브랜드 서브메뉴">
                    <a href="cominfo.php" role="menuitem" tabindex="-1">회사소개</a>
                </div>
            </div>
            <div class="nav-item" role="menuitem" tabindex="0">
                <div class="red-dot"></div>
                제품소식
                <div class="submenu" role="menu" aria-label="제품소식 서브메뉴">
                    <a href="news.php" role="menuitem" tabindex="-1">뉴스</a>
                    <a href="poster.php" role="menuitem" tabindex="-1">포스터</a>
                </div>
            </div>
            <div class="nav-item" role="menuitem" tabindex="0">
                <div class="red-dot"></div>스토어
                <div class="submenu">
                    <!-- 직접 지정한 메뉴 이름과 content_field 값 -->
                    <a href="product.php?content_field=갤럭시 s25">
                        <p>갤럭시 S25 시리즈</p>
                    </a>
                    <a href="product.php?content_field=아이폰 16">
                        <p>아이폰 16 시리즈</p>
                    </a>
                    <a href="product.php?content_field=갤럭시">
                        <p>삼성</p>
                    </a>
                    <a href="product.php?content_field=아이폰">
                        <p>애플</p>
                    </a>
                    <a href="product.php?content_field=악세사리">
                        <p>악세사리</p>
                    </a>
                    <a href="product.php?content_field=충전">
                        <p>충전기</p>
                    </a>
                </div>
            </div>
            <div class="nav-item" role="menuitem" tabindex="0">
                <div class="red-dot"></div>
                이벤트
                <div class="submenu" role="menu" aria-label="이벤트 서브메뉴">
                    <a href="event.php" role="menuitem" tabindex="-1">진행중 이벤트</a>
                    <a href="end_event.php" role="menuitem" tabindex="-1">지난 이벤트</a>
                </div>
            </div>
            <div class="nav-item" role="menuitem" tabindex="0">
                <div class="red-dot"></div>
                고객지원
                <div class="submenu" role="menu" aria-label="고객지원 서브메뉴">
                    <a href="notice.php" role="menuitem" tabindex="-1">공지사항</a>
                    <a href="review.php" role="menuitem" tabindex="-1">REVIEW</a>
                    <a href="faq.php" role="menuitem" tabindex="-1">FAQ</a>
                </div>
            </div>
        </nav>
        <!-- 헤더 오른쪽 -->
        <div class="header-right" style="display:flex; align-items:center;">
            <?php if (isset($_SESSION['nickname'])): ?>
                <!-- 로그인된 경우: 닉네임과 내 정보 페이지만 표시 (디자인 유지) -->
                <div class="user-menu" style="display:flex; align-items:center;">
                    <span class="user-nickname" style="font-weight:bold;">
                        <?php echo htmlspecialchars($_SESSION['nickname']); ?>님
                    </span>
                    <img src="img/myicon.png" alt="User Icon" class="user-icon" tabindex="0">
                    <div class="user-dropdown">
                        <a href="mypage.php">내 정보</a>
                        <a href="logout.php">로그아웃</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- 로그인되지 않은 경우: 기존 드롭다운 메뉴 그대로 노출 -->
                <div class="user-menu" style="display:flex; align-items:center;">
                    <img src="img/myicon.png" alt="User Icon" class="user-icon" tabindex="0">
                    <div class="user-dropdown">
                        <a href="login.php">로그인</a>
                        <a href="termofUse.php">회원가입</a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- 검색 아이콘과 숨겨진 검색창 -->
            <div class="search-container-main">
                <a href="search.php">
                    <img src="img/search.png" alt="검색 아이콘" class="search-icon" tabindex="0" style="cursor:pointer;">
                </a>
            </div>

        </div>


    </header>

    <script>
        // 헤더 투명도 조절
        const header = document.getElementById('mainHeader');
        header.addEventListener('mouseenter', () => header.classList.add('active'));
        header.addEventListener('mouseleave', () => header.classList.remove('active'));
    </script>
</body>

</html>