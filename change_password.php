<?php
session_start();
require_once("inc/db.php");
require_once("inc/header.php");

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION['member_id'];
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <title>비밀번호 변경</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #fff;
            color: #333;
            margin-top: 120px;
        }

        .container {
            max-width: 500px;
            margin: 40px auto 100px auto;
            padding: 0 40px;
        }

        .sale-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .notice-text {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 50px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="password"] {
            width: 100%;
            padding: 16px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.2s ease-in-out;
        }

        input[type="password"]:focus {
            border-color: #000;
            outline: none;
        }

        .button-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 30px;
        }

        button {
            flex: 1;
            padding: 16px 0;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-cancel {
            background: #f0f0f0;
            color: #333;
        }

        .btn-cancel:hover {
            background: #dcdcdc;
        }

        .btn-submit {
            background: #000;
            color: #fff;
        }

        .btn-submit:hover {
            background: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sale-title">비밀번호 변경</div>
        <div class="notice-text">
            비밀번호는 타인이 유추하기 어렵게 영문/숫자/특수문자를 조합하여 설정해 주세요.<br>
            변경 시 자동 로그아웃되며, 새 비밀번호로 다시 로그인하셔야 합니다.
        </div>

        <form method="post" action="change_password_process.php">
            <div>
                <label for="current_password">현재 비밀번호</label>
                <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
            </div>

            <div>
                <label for="new_password">새 비밀번호</label>
                <input type="password" id="new_password" name="new_password" required autocomplete="new-password">
            </div>

            <div>
                <label for="confirm_password">비밀번호 확인</label>
                <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password">
            </div>

            <div class="button-row">
                <button type="button" class="btn-cancel" onclick="history.back();">변경 취소</button>
                <button type="submit" class="btn-submit">변경하기</button>
            </div>
        </form>
    </div>
</body>

<?php require_once("inc/footer.php"); ?>

</html>
