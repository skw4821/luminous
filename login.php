<?php
// index.php (line 1)
session_start();
require_once("inc/header.php");

// 기존 코드...
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luminous</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #fff;
        color: #000;
    }

    main.login_wrapper {
        max-width: 400px;
        margin: 100px auto;
        padding: 40px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .login_start {
        text-align: center;
        margin-bottom: 30px;
    }

    .login_title {
        font-size: 28px;
        font-weight: bold;
    }

    fieldset {
        border: none;
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #000;
        border-radius: 8px;
        font-size: 16px;
        background-color: #fff;
        color: #000;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        outline: none;
        border-color: #000;
        background-color: #f9f9f9;
    }

    .login_keep_wrapper {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        margin-bottom: 20px;
        color: #333;
    }

    .finish_login_wrapper {
        text-align: center;
        margin-bottom: 20px;
    }

    .finish_login {
        width: 100%;
        padding: 12px;
        background-color: #000;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .finish_login:hover {
        background-color: #333;
    }

    .login_or {
        text-align: center;
        font-size: 12px;
        color: #999;
        margin: 20px 0;
    }

    .login_sns_wrapper {
        text-align: center;
    }

    .kakao_login {
        background-color: #f7e600;
        color: #000;
        padding: 12px;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        margin-bottom: 20px;
    }

    .kakao_login:hover {
        background-color: #eedc00;
    }

    .find_wrapper {
        margin-top: 30px;
        text-align: center;
    }

    .find_wrapper ul {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: center;
        gap: 20px;
        font-size: 14px;
    }

    .find_wrapper ul a {
        text-decoration: none;
        color: #000;
        transition: color 0.3s;
    }

    .find_wrapper ul a:hover {
        color: #555;
    }

    .none_border {
        border: none !important;
    }

    @media (max-width: 500px) {
        main.login_wrapper {
            margin: 50px 20px;
            padding: 30px;
        }

        .login_title {
            font-size: 24px;
        }

        .finish_login {
            font-size: 14px;
        }
    }
</style>

<body>
    <?php require_once("inc/header.php"); ?>

    <main class="login_wrapper member">
        <div class="login_start">
            <span class="login_title"> 로그인 </span>
        </div>
        <form name="login_form" method="POST" action="login.post.php">
            <div class="ID_wrapper">
                <fieldset class="ID_field-container">
                    <input type="text" placeholder="아이디를 입력하세요." class="ID_field_text" name="id" />
                </fieldset>
            </div>
            <div class="FW_wrapper">
                <fieldset class="FW_field-container">
                    <input type="password" placeholder="비밀번호를 입력하세요." class="FW_field_text" name="pass" />
                </fieldset>
            </div>
            <div class="login_keep_wrapper">
                <div class="ID_keep_check">
                    <input type="checkbox" class="input_ID_keep">
                    <lavel for="ID_keep" class="ID_keep_text"> 아이디 저장 </lavel>
                </div>
                <div class="all_keep_check">
                    <input type="checkbox" class="input_all_keep">
                    <lavel for="all_keep" class="all_keep_text"> 로그인 상태 유지 </lavel>
                </div>
            </div>
            <div class="finish_login_wrapper">
                <button class="finish_login" onclick="login()">
                    <span class="finish_login_title"> 로그인 </span>
                </button>
            </div>
            <div class="login_or">
                <span class="login_or_title"> ------------------------------------- 또는
                    ----------------------------------- </span>
            </div>
            <div class="login_sns_wrapper">
                <a href="https://accounts.kakao.com/login/?continue=https%3A%2F%2Fcs.kakao.com%2Fhelps%3Fcategory%3D166%26service%3D52#login">
                    <div class="kakao_login">
                        <span class="kakao_login_title"> 카카오 1초 로그인 / 회원가입 </span>
                    </div>
                </a>
            </div>
        </form>

        <div class="find_wrapper">
            <ul>
                <a href="termofUse.php">
                    <li> <span>회원가입</span>
                    </li>
                </a>
                <a href="">
                    <li> <span>아이디 찾기</span> </li>
                </a>
                <a href="">
                    <li class="none_border"> <span>비밀번호 찾기</span> </li>
                </a>
            </ul>
        </div>

        <!-- class="find_text" -->

        <div class="login_member_non_member"></div>

    </main>

    <?php require_once("inc/footer.php"); ?>

    <script src="https://kit.fontawesome.com/73fbcb87e6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script src="../js/hot_issue.js"></script>
    <script src="js/member.js"></script>
</body>

</html>