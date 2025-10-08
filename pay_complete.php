<?php require_once("contents.import.php");?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>HARU</title>
</head>

<body>
    <div class="adv_main">adv</div>
    <?php require_once("inc/header.php"); ?>

    <main class="cart_wrapper pay">
        <section class="pay_complete_header">
            <span class="pay_comp_title"> 주문 완료 </span>
            <div class="pay_back_buttons">
                <a href="pay.php">
                    <button> < 이전 페이지 </button>
                </a>
            </div>
        </section>
        <section class = "complete_info">
            <table>
                <tr class = "table_comp_info">
                    <td> 주문 완료 </td>
                </tr>
            </table>
            <div class = "comp_detail_info">
                <div class= "comp_detail_wrapper">
                    <div class="comp_one"> 주문이 완료되었습니다. </div>
                    <div class="comp_two"> 주문번호: 29947370 </div>
                </div>
            </div>
        </section>
        <section class="pay_comp_list">
            <table>
                <tr class="pay_table_header">
                    <td>상품 정보</td>
                </tr>
                <tr>
                <td class="check"><input type="checkbox"></td>
                    <td><div class="pay_img_wrapper"></div></td>
                    <td>상품 정보</td>
                    <td>50,500원</td>
                    <td>1개</td>
                    <td>50,500원</td>
                    <td>50,500원</td>
                </tr>
            </table>
        </section>
        <section class="comp_detail_buttons">
            <a href="">
                <button class="comp_detail">
                    주문 상세 보기
                </button>
            </a>
            <a href="index.php">
                <button class="comp_main_move"> 홈으로 </button>
            </a>
        </section>
    </main>

    <?php require_once("inc/footer.php"); ?>

    <script src="https://kit.fontawesome.com/73fbcb87e6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script src="js/hot_issue.js"></script>
    <script src="js/member.js"></script>
    
</body>

</html>
