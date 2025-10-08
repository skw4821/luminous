<!-- 생략된 PHP 로직은 동일하므로 그대로 유지 -->
<?php
session_start();
require_once("inc/db.php");
require_once("inc/header.php");

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION['member_id'];
$member = db_select("SELECT * FROM Member WHERE member_id = ?", [$member_id]);
$member = is_array($member) && count($member) > 0 ? $member[0] : [];

$nickname = $member['nickname'] ?? '';
$name = $member['name'] ?? '';
$email = $member['email'] ?? '';
$login_id = $member['login_id'] ?? '';
$address = $member['address'] ?? '';

$phone1 = '010';
$phone2 = $phone3 = '';
if (!empty($member['phone_number']) && strlen($member['phone_number']) === 11) {
    $phone2 = substr($member['phone_number'], 3, 4);
    $phone3 = substr($member['phone_number'], 7, 4);
}

$gender = '';
if (!empty($member['gender'])) {
    if ($member['gender'] === 'MALE') $gender = 'M';
    elseif ($member['gender'] === 'FEMALE') $gender = 'F';
}

$birthdate = $member['birthdate'] ?? '';
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <title>회원정보 수정</title>
    <style>
        body {
            font-family: 'Pretendard', sans-serif;
            background: #fff;
            color: #000;
            margin-top: 80px;
            margin-bottom: 80px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .sale-title {
            font-size: 28px;
            font-weight: 700;
            margin: 60px 0 40px;
            text-align: center;
        }

        .card {
            background: #fff;
            border: 1px solid #ddd;
            padding: 40px 30px;
            margin-bottom: 50px;
            box-shadow: 0 0 10px #eee;
            border-radius: 6px;
            text-align: center;
        }

        .card h3 {
            margin-bottom: 10px;
            font-size: 22px;
            font-weight: 700;
        }

        .card .value {
            font-size: 18px;
            font-weight: 500;
            color: #444;
        }

        table.form-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.form-table th,
        table.form-table td {
            padding: 14px 12px;
            vertical-align: middle;
            border-top: 1px solid #e1e1e1;
            font-size: 15px;
        }

        table.form-table tr:first-child th,
        table.form-table tr:first-child td {
            border-top: 2px solid #000;
        }

        table.form-table tr:last-child th,
        table.form-table tr:last-child td {
            border-bottom: 1px solid #000;
        }

        table.form-table th {
            width: 180px;
            text-align: left;
            background-color: #fafafa;
            font-weight: 600;
        }

        .required {
            color: red;
            margin-right: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-sizing: border-box;
            border-radius: 3px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: #000;
            outline: none;
        }

        .inline-inputs {
            display: flex;
            gap: 10px;
        }

        .inline-inputs select[disabled] {
            appearance: none;
            background-color: #f9f9f9;
            border: none;
            padding-left: 0;
            font-size: 14px;
            color: #000;
            cursor: default;
            width: 70px;
        }

        .inline-inputs input {
            flex: 1;
            min-width: 0;
        }

        .btn-small {
            padding: 7px 15px;
            background: #000;
            color: #fff;
            font-size: 13px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
            vertical-align: middle;
        }

        .btn-small:hover {
            background: #444;
        }

        .btn-group {
            text-align: center;
            margin-top: 50px;
        }

        .btn-group button {
            padding: 14px 40px;
            background: #000;
            color: #fff;
            border: none;
            font-size: 16px;
            margin: 0 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-group button:hover {
            background: #333;
        }

        .section-box {
            margin: 80px 0 40px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 40px;
            padding-bottom: 20px;
            text-align: left;
        }

        .btn-delete {
            display: block;
            margin: 40px auto 0;
            background: #fff;
            color: red;
            border: 2px solid red;
            padding: 14px 0;
            width: 180px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .btn-delete:hover {
            background: red;
            color: #fff;
        }

        header.header#mainHeader {
            background-color: white !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sale-title">회원정보 수정</div>

        <div class="card">
            <h3>안녕하세요. <?= htmlspecialchars($nickname) ?> 님!</h3>
            <div class="value">회원정보를 수정해 주세요</div>
        </div>
        <div style="text-align: right; font-size: 14px; color: #000; margin-bottom: 5px;">
            <span class="required">*</span>필수입력항목
        </div>
        <form action="update_profile.php" method="POST" autocomplete="off" novalidate>
            <table class="form-table" summary="회원정보 수정 폼">
                <tbody>
                    <tr>
                        <th><span class="required">*</span>아이디</th>
                        <td><input type="text" name="login_id" value="<?= htmlspecialchars($login_id) ?>" readonly></td>
                    </tr>
                    <tr>
                        <th><span class="required">*</span>비밀번호</th>
                        <td><input type="password" name="password" placeholder="변경 시에만 입력 (8자 이상)" minlength="8" autocomplete="new-password"></td>
                    </tr>
                    <tr>
                        <th><span class="required">*</span>비밀번호 확인</th>
                        <td><input type="password" name="password_confirm" placeholder="위 비밀번호와 동일하게 입력" autocomplete="new-password"></td>
                    </tr>
                    <tr>
                        <th><span class="required">*</span>이름</th>
                        <td><input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required></td>
                    </tr>
                    <tr>
                        <th><span class="required">*</span>주소</th>
                        <td><input type="text" name="address" value="<?= htmlspecialchars($address) ?>" required></td>
                    </tr>
                    <tr>
                        <th><span class="required">*</span>휴대전화</th>
                        <td class="inline-inputs">
                            <select name="phone1" disabled>
                                <option value="010" selected>010</option>
                            </select>
                            <input type="hidden" name="phone1" value="010">
                            <input type="text" name="phone2" value="<?= htmlspecialchars($phone2) ?>" maxlength="4" pattern="\d*" required>
                            <input type="text" name="phone3" value="<?= htmlspecialchars($phone3) ?>" maxlength="4" pattern="\d*" required>
                        </td>
                    </tr>
                    <tr>
                        <th><span class="required">*</span>이메일</th>
                        <td><input type="email" name="email_edit" value="<?= htmlspecialchars($email) ?>" required></td>
                    </tr>
                </tbody>
            </table>

            <div class="section-box">
                <div class="section-title">추가 정보</div>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th><span class="required">*</span>닉네임</th>
                            <td><input type="text" name="nickname" value="<?= htmlspecialchars($nickname) ?>" required></td>
                        </tr>
                        <tr>
                            <th><span class="required">*</span>성별</th>
                            <td>
                                <label><input type="radio" name="gender" value="M" <?= $gender === 'M' ? 'checked' : '' ?>> 남성</label>
                                <label style="margin-left:20px;"><input type="radio" name="gender" value="F" <?= $gender === 'F' ? 'checked' : '' ?>> 여성</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="btn-group">
                <button type="submit">수정하기</button>
                <button type="button" onclick="location.href='mypage.php'">취소</button>
            </div>
        </form>

        <button type="button" class="btn-delete" onclick="if(confirm('정말 탈퇴하시겠습니까?')) location.href='delete_account.php'">회원 탈퇴</button>
    </div>
</body>
<?php require_once("inc/footer.php"); ?>

</html>