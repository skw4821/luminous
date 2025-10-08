<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Luminous</title>
    <style>
        header.header#mainHeader {
            background-color: white !important;
        }

        body {
            background-color: #fff;
            color: #000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .main_wrapper {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 10px;
            box-sizing: border-box;
        }

        .progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .progress_step {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-bottom: 2px solid #ccc;
            color: #666;
            font-weight: 600;
        }

        .progress_step.step1 {
            border-bottom-color: #000;
            color: #000;
        }

        .join_us_title {
            display: block;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
            text-align: center;
            letter-spacing: 1px;
            color: #000;
        }

        .join_check_img {
            display: block;
            margin: 20px auto;
            width: 80px;
            height: auto;
        }

        .join_box_in_text {
            text-align: center;
        }

        .finish_login {
            display: block;
            /* 블록으로 만들어서 가로 100% 차지 가능 */
            width: 260px;
            margin: 40px auto 0;
            /* 위쪽 40px 띄우고 좌우 자동으로 가운데 정렬 */
            padding: 16px 0;
            background-color: #000;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            border-radius: 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .finish_login:hover {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php require_once("inc/header.php"); ?>
    <main class="main_wrapper sign_up">
        <div class="progress">
            <div class="progress_step">
                <span class="title">STEP 1</span>
                <span>이용약관 동의</span>
            </div>
            <div class="progress_step">
                <span class="title">STEP 2</span>
                <span>회원정보 입력</span>
            </div>
            <div class="progress_step step1">
                <span class="title">STEP 3</span>
                <span>회원가입 완료</span>
            </div>
        </div>
        <span class="join_us_title">회원가입</span>
        <div class="join_box">

            <div class="join_box_in_text">
                <span class="join_us_in_title">Luminous</span><br>
                <img src="img/check.png" class="join_check_img">
                <span class="join_us_in_text_title">회원가입 완료<br></span>
                <span class="join_us_in_text">
                    회원님의 님의 아이디 회원가입이 <br>
                    정상적으로 완료 되었습니다<br>
                </span>
                <div class="join_us_boxs"> 회원정보 수정은
                    <span class="text_point">마이페이지 > 회원정보 수정</span>
                    에서 수정할 수 있습니다.
                </div>

            </div>
            <section>

            </section>

    </main>
    <a href="login.php" class="finish_login">로그인 바로하기</a>

    <script src="js/member.js"></script>
</body>
<?php require_once("inc/footer.php"); ?>

</html>