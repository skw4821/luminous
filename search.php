<?php require_once("inc/header.php"); ?>

<style>
  /* 심플한 흑백 스타일 */
  .search-container {
    max-width: 600px;
    margin: 120px auto 60px; /* 헤더 공간 고려, 위쪽 충분히 띄움 */
    padding: 20px;
    background: #fff;
    color: #000;
    border: 1px solid #000;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    font-family: 'Arial', sans-serif;
  }

  .search-container h1 {
    text-align: center;
    margin-bottom: 30px;
    font-weight: bold;
    font-size: 2rem;
  }

  form.search-form {
    display: flex;
    gap: 10px;
  }

  form.search-form input[type="text"] {
    flex-grow: 1;
    padding: 12px 15px;
    font-size: 1rem;
    border: 1px solid #000;
    border-radius: 4px;
    background: #fff;
    color: #000;
  }

  form.search-form input[type="text"]:focus {
    outline: none;
    border-color: #222;
  }

  form.search-form button {
    padding: 12px 25px;
    background: #000;
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s;
  }

  form.search-form button:hover {
    background: #333;
  }

  .search-results {
    margin-top: 30px;
  }

  .search-results ul {
    list-style: none;
    padding-left: 0;
  }

  .search-results li {
    padding: 10px 15px;
    border-bottom: 1px solid #eee;
  }

  .search-results li:last-child {
    border-bottom: none;
  }

  .no-results {
    text-align: center;
    color: #666;
    margin-top: 20px;
  }
</style>

<div class="search-container">
  <h1>검색</h1>

  <?php
  $searchQuery = '';
  $searchResults = [];

  if (isset($_GET['q'])) {
      $searchQuery = trim($_GET['q']);

      // 예시 데이터 (실제로는 DB에서 검색)
      $data = [
          '갤럭시 S25',
          '아이폰 16',
          '삼성 악세사리',
          '애플 악세사리',
          '기타 스마트폰',
          '신제품',
          '이벤트',
          '고객지원'
      ];

      foreach ($data as $item) {
          if (mb_stripos($item, $searchQuery) !== false) {
              $searchResults[] = $item;
          }
      }
  }
  ?>

  <form class="search-form" method="get" action="search.php" role="search" aria-label="사이트 검색">
    <input 
      type="text" 
      name="q" 
      placeholder="검색어를 입력하세요" 
      value="<?= htmlspecialchars($searchQuery) ?>" 
      aria-label="검색어 입력"
      required 
      autocomplete="off"
    />
    <button type="submit" aria-label="검색하기">검색</button>
  </form>

  <?php if ($searchQuery !== ''): ?>
    <div class="search-results" role="region" aria-live="polite" aria-atomic="true">
      <h2>검색 결과: "<?= htmlspecialchars($searchQuery) ?>"</h2>

      <?php if (count($searchResults) > 0): ?>
        <ul>
          <?php foreach ($searchResults as $result): ?>
            <li><?= htmlspecialchars($result) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="no-results">검색 결과가 없습니다.</p>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>

<?php require_once("inc/footer.php"); ?>
