<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>관리자 페이지-공지사항</title>
</head>

<body id="manager_body">
    <main class="manager_wrapper registration">
        <div class="main_menu_wrapper">
            <a href="manager_home.php">
                <div class="menu"> 홈 </div>
            </a>
            <a href="manager_notice.php">
                <div class="menu"> 공지사항 관리 </div>
            </a>
            <a href="manager_product.php">
                <div class="menu" style="background-color:  rgb(74 173 255);"> 상품 관리 </div>
            </a>
            <a href="manager_event.php">
                <div class="menu"> 이벤트 관리 </div>
            </a>
            <a href="manager_inquiry.php">
                <div class="menu"> 고객 문의 관리 </div>
            </a>
        </div>

        <div class="main_registration">
            <header>
                <div class="title_and_registration">
                    <span class="title">상품 등록</span>
                </div>
            </header>
            <section class="contents">
                
                <article class="scroller">
                    <form action="contents_insert.php" method="POST">
                        <section class="board product">
                            <div class="point_img">
                                <div class="img_insert_header">
                                    <div class="point_title"> 대표 이미지 </div>
                                </div>
                                <section class="img_thumbnail">
                                    <input class="input_css" name="content_img" type="text" placeholder="썸네일에 들어갈 이미지주소를 입력해주세요." value="img/contents/content1.jpg"/>
                                </section>
                                <div class="img_insert_header">
                                    <div class="point_title"> 추가 이미지 </div>
                                </div>
                                <section class="img_more">
                                    <input class="input_css" type="text" name="content_img1" placeholder="추가할 이미지 1">
                                    <input class="input_css" type="text" name="content_img2" placeholder="추가할 이미지 2">
                                    <input class="input_css" type="text" name="content_img3" placeholder="추가할 이미지 3">
                                    <input class="input_css" type="text" name="content_img4" placeholder="추가할 이미지 4">
                                </section>
                                <div class="img_insert_header">
                                    <div class="point_title"> 상품 정보 </div>
                                </div>
                                <div class="product_detail">
                                    <div class="product_board_three">
                                        <div class="product_code"> 상품코드 : <input type="text" name="product_code" class="text_product_code"></div>
                                        <div class="product_name"> 상품명 : <input type="text" name="product_name" class="text_product_name"></div>
                                        <div class="product_cost"> 상품 원가 : <input type="text" name="content_cost" class="text_product_cost">원</div>
                                        <div class="product_price"> 상품 가격 : <input type="text" name="product_price" class="text_product_price">원</div>
                                    </div>
                                    <div class="product_board_two">
                                        <div class="product_category"> 
                                            상품 대분류 :
                                            <select name="category_large" onchange="Category_Change(this)">
                                                <option value="no_select"> 선택해주세요. </option>
                                                <option name="outer" value="outer"> 아우터 </option>
                                                <option name="top" value="top"> 상의 </option>
                                                <option name="traning" value="traning"> 트레이닝 </option>
                                                <option name="basic" value="basic"> 베이직 </option>
                                                <option name="one_piece" value="one_piece"> 원피스 </option>
                                                <option name="skirt" value="skirt"> 스커트 </option>
                                                <option name="pants" value="pants"> 팬츠 </option>
                                                <option name="bag" value="bag"> 가방 </option>
                                                <option name="shoes" value="shoes"> 신발 </option>
                                                <option name="accessory" value="accessory"> 액세서리 </option>
                                            </select>
                                        </div>
                                        <div class="product_category"> 
                                            상품 소분류 :
                                            <select id="category_small" name="category_small">
                                                <option value="no_select">선택해주세요.</option>
                                            </select>
                                        </div>
                                        <div class="product_discount_rate"> 할인율 : <input type="text" name="product_discount_rate"class="text_product_discount" /> %</div>
                                        <div class="is_deliv_today"> 오늘배송 :
                                            <select name="is_deliv_today" class = "deliv_today_choice">
                                                <option> N </option>
                                                <option> Y </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="img_insert_header">
                                    <div class="point_title"> 상품 색상 등록 </div>
                                </div>
                                
                                <div class="pro_sign_up_colors">
                                    <input class="input_color_css content_color1" type="color" name="content_color1" value="#fffff">
                                    <input class="input_color_css" type="color" name="content_color2">
                                    <input class="input_color_css" type="color" name="content_color3">
                                    <input class="input_color_css" type="color" name="content_color4">
                                </div>
                                
                                    
                                <div class="submit_wrapper">
                                    <label class="input-submit-button" for="input-submit">
                                            확인
                                    </label>
                                    <input type="submit" id="input-submit" style="display: none;">
                                </div>
                            </div>
                        </section>
                    </section>
                    </form>
                    
                </article>
            </section>
            
        </div>
    </main>

    <script src="js/app.js"></script>
</body>

</html>