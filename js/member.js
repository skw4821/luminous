function check_input() {
    const form = document.forms.member_form;
    const data = {
        loginId: form.id.value, // 로그인 ID
        password: form.pass.value, // 비밀번호
        name: form.name.value, // 이름
        address: form.address.value, // 주소
        phoneNumber: form.phone.value, // 전화번호
        email: form.email1.value + '@' + form.email2.value, // 이메일 합치기
        nickname: form.nickname.value, // 닉네임
        gender: form.gender.value, // 성별(MALE/FEMALE)
        birth: form.birth.value // 생년월일 (DB에 컬럼이 없으니, 필요시 컬럼 추가)
  // 관리자 여부(admin)는 회원가입 시 일반적으로 입력받지 않으므로 제외
};
// API 요청시 상대 경로 사용
    fetch('/api/join', {  
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data),
    credentials: 'include'
});

}


function login() {
	console.log('login()');
	document.login_form.submit();
}

function checkDuplicate() {
    const login_id = document.querySelector('input[name="id"]').value.trim();
    const resultElem = document.getElementById("id_check_result");

    if (login_id === "") {
        resultElem.style.color = "red";
        resultElem.textContent = "아이디를 입력하세요.";
        return;
    }

    // 쿼리 파라미터로 login_id 전달
    fetch(`/api/checkId?login_id=${encodeURIComponent(login_id)}`)
        .then(response => {
            if (!response.ok) throw new Error("서버 오류");
            return response.json();
        })
        .then(data => {
            if (data.exists) {
                resultElem.style.color = "red";
                resultElem.textContent = "이미 사용 중인 아이디입니다.";
            } else {
                resultElem.style.color = "green";
                resultElem.textContent = "사용 가능한 아이디입니다.";
            }
        })
        .catch(error => {
            resultElem.style.color = "red";
            resultElem.textContent = "오류가 발생했습니다.";
        });
}

