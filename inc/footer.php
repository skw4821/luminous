<footer class="site-footer">
  <div class="footer-top">
    <div class="footer-col">
      <div class="footer-title">고객센터</div>
      <div class="footer-cs-phone">1588-1234</div>
      <div class="footer-cs-time">
        <div>평일 10:00 ~ 18:00</div>
        <div>토요일 10:00 ~ 15:00</div>
        <div>점심시간 12:00 ~ 13:00</div>
      </div>
      <div class="footer-cs-btns">
        <button>카카오톡 문의</button>
        <button>빠른 교환/반품 신청</button>
      </div>
    </div>
    <div class="footer-col">
      <div class="footer-title">BANK INFO</div>
      <div>국민 123456-04-295384</div>
      <div>신한 140-014-640356</div>
      <div>예금주: (주)루미너스</div>
    </div>
    <div class="footer-col">
      <div class="footer-title">COMPANY</div>
      <div>상호: Luminous</div>
      <div>대표: 이재민</div>
      <div>사업자등록번호: 123456-1245678</div>
      <div>주소: 경기도 성남시 중원구 광명로 377</div>
      <div>이메일: info@luminous.com</div>
    </div>
    <div class="footer-col">
      <div class="footer-title">INFORMATION</div>
      <a href="#">이용약관</a>
      <a href="#">개인정보 처리방침</a>
      <a href="#">멤버십 안내</a>
      <a href="#">관리자 페이지</a>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="footer-social">
      <span>FOLLOW US</span>
      <a href="#">@instagram</a>
      <a href="#">@facebook</a>
      <a href="#">@youtube</a>
      <a href="#">@blog</a>
    </div>
    <div class="footer-copyright">
      Copyright 2024 Luminous All rights reserved.
    </div>
  </div>
</footer>

<style>
.site-footer {
  background: #fafafa;
  color: #222;
  font-family: 'Noto Sans KR', sans-serif;
  font-size: 15px;
  border-top: 1px solid #e5e5e5;
  margin-top: 60px;
}
.footer-top {
  display: flex;
  flex-wrap: wrap;
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px 20px 20px;
  justify-content: space-between;
  gap: 32px;
}
.footer-col {
  flex: 1 1 180px;
  min-width: 180px;
  margin-bottom: 16px;
}
.footer-title {
  font-weight: 700;
  font-size: 1.08em;
  margin-bottom: 14px;
  letter-spacing: 0.01em;
}
.footer-cs-phone {
  font-size: 1.15em;
  font-weight: 600;
  margin-bottom: 6px;
}
.footer-cs-time > div {
  margin-bottom: 2px;
}
.footer-cs-btns {
  margin-top: 8px;
}
.footer-cs-btns button {
  background: #222;
  color: #fff;
  border: none;
  border-radius: 18px;
  padding: 5px 18px;
  font-size: 0.98em;
  margin-right: 6px;
  margin-bottom: 4px;
  cursor: pointer;
  transition: background 0.2s;
}
.footer-cs-btns button:hover {
  background: #444;
}
.footer-col a {
  display: block;
  color: #222;
  text-decoration: none;
  margin-bottom: 7px;
  transition: color 0.2s;
}
.footer-col a:hover {
  color: #4a90e2;
}
.footer-bottom {
  border-top: 1px solid #e5e5e5;
  margin-top: 18px;
  padding: 14px 20px 12px 20px;
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  font-size: 0.98em;
}
.footer-social {
  color: #666;
}
.footer-social a {
  color: #666;
  margin-left: 10px;
  text-decoration: none;
  transition: color 0.2s;
}
.footer-social a:hover {
  color: #4a90e2;
}
.footer-copyright {
  color: #aaa;
  text-align: right;
  flex: 1 1 200px;
}
@media (max-width: 900px) {
  .footer-top {
    flex-direction: column;
    gap: 0;
  }
  .footer-col {
    margin-bottom: 22px;
  }
  .footer-bottom {
    flex-direction: column;
    gap: 6px;
    text-align: center;
  }
}
</style>
