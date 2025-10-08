
let ContentPrice = document.querySelector('.price_final'); // 상품 금액
let TotalPrice = document.querySelector('.total_price'); // 총 금액
let Option3Price = document.querySelector('.option3_price'); // 상품 금액 * 상품 수량

// 초기 ContentPrice 값 가져오기
let contentPriceValue = parseInt(ContentPrice.textContent.replace(',', '').trim()); // 상품 가격을 숫자로 변환
ContentPrice.innerHTML = contentPriceValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','); // 가격에 콤마 추가

let Price = 0; // 상품금액 * 상품수량 계산값

// 옵션 선택 시 호출되는 함수
function SelectOption() {
    let CheckedSize = document.getElementById("size_select").value; // 선택된 용량
    let Option1Size = document.querySelector('.option1_size');
    let Option2Amount = $('input[name=option2_amount]'); // 상품 수량

    // 용량 선택에 따른 가격 변환 (기본 가격에 추가 금액 적용)
    let additionalPrice = 0;

    // 용량 선택에 따른 가격 설정
    if (CheckedSize === "30") {
        additionalPrice = 0; // 30ml 가격
    } else if (CheckedSize === "60") {
        additionalPrice = 5000; // 50ml 가격
    } else if (CheckedSize === "100") {
        additionalPrice = 10000; // 100ml 가격
    }

    // 선물용을 선택하면 2000원 추가
    let giftOptionPrice = 0;
    if (document.getElementById("gift_select").value === "선물용") {
        giftOptionPrice = 2000; // 선물용 추가 금액
    }

    // 가격 계산 (상품 금액 + 용량 추가 금액 + 선물용 추가 금액) * 상품 수량
    Price = (contentPriceValue + additionalPrice + giftOptionPrice) * Number(Option2Amount.val()); // 상품금액 + 용량 추가금액 + 선물용 추가금액 * 수량 계산

    // 가격에 콤마 추가
    Price = Price.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ',');
    Option1Size.innerHTML = CheckedSize; // 선택된 용량 표시
    Option3Price.innerHTML = Price; // 최종 가격 갱신
    TotalPrice.innerHTML = Price; // 총 결제 금액을 갱신
    document.querySelector('.content').style.display = 'flex';
    $('input:hidden[name=content_options]').attr('value', CheckedSize);
}

// 수량 변경 시 호출되는 함수
function AmountChange() {
    let Option2Amount = $('input[name=option2_amount]'); // 상품 수량
    let CheckedSize = document.getElementById("size_select").value; // 선택된 용량

    // 용량 선택에 따른 추가 금액
    let additionalPrice = 0;

    // 용량 선택에 따른 가격 설정
    if (CheckedSize === "30") {
        additionalPrice = 0; // 30ml 가격
    } else if (CheckedSize === "60") {
        additionalPrice = 5000; // 50ml 가격
    } else if (CheckedSize === "100") {
        additionalPrice = 10000; // 100ml 가격
    }

    // 선물용을 선택하면 2000원 추가
    let giftOptionPrice = 0;
    if (CheckedSize === "선물용") {
        giftOptionPrice = 2000; // 선물용 추가 금액
    }

    // 가격 계산 (상품 금액 + 용량 추가 금액 + 선물용 추가 금액) * 상품 수량
    Price = (contentPriceValue + additionalPrice + giftOptionPrice) * Number(Option2Amount.val()); // 상품금액 + 용량 추가금액 + 선물용 추가금액 * 수량 계산

    // 가격에 콤마 추가
    Price = Price.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ',');
    Option3Price.innerHTML = Price; // 최종 가격 갱신
    TotalPrice.innerHTML = Price; // 총 결제 금액을 갱신
}

// X 선택하면 상품옵션 선택 없어짐
const deleteBtn = document.querySelector('.delete');

deleteBtn.addEventListener('click', function () {
    document.querySelector('.content').style.display = 'none';
    $('input:radio[name=size]').prop('checked', false);
});