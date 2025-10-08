<!DOCTYPE html>
<?php require_once("inc/header.php"); ?>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>약관동의</title>
    <style>
        header.header#mainHeader {
            background-color: white !important;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: left;
            margin: 180px auto 80px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .checkbox-group {
            margin: 15px 0;
        }

        .checkbox-group label {
            margin-left: 8px;
            color: #555;
        }

        .checkbox-group p {
            font-size: 0.9em;
            color: #777;
            margin: 5px 0 0 25px;
        }

        button {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 12px 0;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        footer {
            margin-top: auto;
            /* 푸터가 페이지 하단에 위치하도록 함 */
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
    </style>
    <script>
        function validateForm() {
            const requiredCheckboxes = document.querySelectorAll('.required');
            for (let checkbox of requiredCheckboxes) {
                if (!checkbox.checked) {
                    alert("필수 항목에 동의해야 합니다.");
                    return false;
                }
            }
            return true;
        }

        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (let checkbox of checkboxes) {
                checkbox.checked = source.checked;
            }
        }
    </script>
</head>

<body>

    <div class="container">
        <div class="progress">
            <div class="progress_step step1">
                <span class="title">STEP 1</span>
                <span>이용약관 동의</span>
            </div>
            <div class="progress_step step2">
                <span class="title">STEP 2</span>
                <span>회원정보 입력</span>
            </div>
            <div class="progress_step step3">
                <span class="title">STEP 3</span>
                <span>회원가입 완료</span>
            </div>
        </div>
        <form action="sign_up.php" method="post" onsubmit="return validateForm()">
            <h2>약관 동의</h2>
            <div class="checkbox-group">
                <input type="checkbox" id="agreeAll" onclick="toggleAll(this)">
                <label for="agreeAll"><strong>전체 동의하기</strong></label>
                <p>전체 동의는 필수 및 선택 정보를 포함합니다. 개별적으로 동의 선택 가능합니다.</p>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" class="required">
                <label for="terms">[필수] Luminous 이용약관 동의 ></label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="privacy" name="privacy" class="required">
                <label for="privacy">[필수] 개인정보 수집 및 이용 ></label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="thirdParty" name="thirdParty" class="required">
                <label for="thirdParty">[필수] 개인정보 제 3자 제공 동의 ></label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="ads" name="ads">
                <label for="ads">[선택] 광고성 정보 수신 동의 ></label>
            </div>
            <button type="submit">동의하고 진행</button>
        </form>
    </div>

    <?php require_once("inc/footer.php"); ?>
</body>

</html>