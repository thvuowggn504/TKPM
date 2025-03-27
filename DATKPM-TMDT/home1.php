<?php
session_start(); // Bắt đầu session để kiểm tra trạng thái đăng nhập
require_once 'product_database.php';

// Xử lý đăng xuất
if (isset($_GET['logout'])) {
  session_unset(); // Xóa tất cả dữ liệu session
  session_destroy(); // Hủy session
  header("Location: lg&rgt.php");
  exit();
}

$productsDB = new Product_Database();
$allProducts = $productsDB->getAllProducts();

$categoriesFromDB = [];
foreach ($allProducts as $product) {
  $categoryID = $product['CategoryID'];
  $sql = $productsDB->getConnection()->prepare("SELECT CategoryName FROM Categories WHERE CategoryID = ?");
  $sql->bind_param("i", $categoryID);
  $sql->execute();
  $categoryResult = $sql->get_result()->fetch_assoc();
  $normalizedCategoryName = strtolower($categoryResult['CategoryName']);

  $categoriesFromDB[$normalizedCategoryName] = $categoriesFromDB[$normalizedCategoryName] ?? [];
  $categoriesFromDB[$normalizedCategoryName][] = $product['ProductName'];
}

// Kiểm tra trạng thái đăng nhập
$isLoggedIn = isset($_SESSION['currentUser']);
$username = $isLoggedIn ? $_SESSION['currentUser']['name'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="public/css/styles-home.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
  <title>E-COMMERCE</title>
</head>

<body>
  <header>
    <div class="logo">
      <img src="public/img/logo.png" alt="logo" />
      <a href="">TPV E-COMMERCE</a>
    </div>
    <nav>
      <a href="#">Home</a>
      <a href="#">Mac</a>
      <a href="#">Iphone</a>
      <a href="#">Watch</a>
      <a href="#">AirPods</a>
      <div class="search-container">
        <div class="search-box">
          <svg class="search-icon-input" width="20" height="20" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="7" stroke="black" stroke-width="2" />
            <line x1="16.5" y1="16.5" x2="22" y2="22" stroke="black" stroke-width="2" stroke-linecap="round" />
          </svg>
          <input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm" />
        </div>
        <div class="dropdown-search" id="dropdown-search">
          <p>Nhập từ khóa để tìm kiếm...</p>
        </div>
      </div>
      <?php if (!$isLoggedIn): ?>
        <a href="lg&rgt.php" id="login-btn"><button><span>Login</span></button></a>
      <?php else: ?>
        <div id="user-info">
          <span id="username"><?php echo htmlspecialchars($username); ?></span>
          <div class="user-dropdown">
            <a href="user-profile.html">Thông tin cá nhân</a>
            <a href="?logout=true" class="logout-text">Đăng xuất</a>
          </div>
        </div>
      <?php endif; ?>
    </nav>
    <div class="hamburger-menu">
      <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 18L20 18" stroke="#ffffff" stroke-width="2" stroke-linecap="round" />
        <path d="M4 12L20 12" stroke="#ffffff" stroke-width="2" stroke-linecap="round" />
        <path d="M4 6L20 6" stroke="#ffffff" stroke-width="2" stroke-linecap="round" />
      </svg>
    </div>
  </header>

  <section>
    <div class="container">
      <div class="content">
        <h1>Welcome</h1>
        <p>
          Discover thousands of high-quality products at unbeatable prices only at TPV <b>E_COMMERCE</b>.<br> We provide
          a seamless, secure, and convenient online shopping experience,<br> making it easier than ever to find
          everything
          you need.
        </p>
        <div class="action">
          <button class="action-1">Action 1</button>
          <button class="action-2">Action 2</button>
        </div>
      </div>
      <div class="card-stack">
        <div class="card left" data-position="left">
          <img src="public/img/iphone16pm.jpg" alt="iPhone">
          <div class="title">iPhone Pro</div>
        </div>
        <div class="card center" data-position="center">
          <img src="public/img/Airpod_pro2.jpg" alt="MacBook">
          <div class="title">Airpods Pro 2</div>
        </div>
        <div class="card right" data-position="right">
          <img src="public/img/78446_laptop_lenovo_ideapad_gami-removebg-preview.png" alt="Apple Watch">
          <div class="title">Macbook Air</div>
        </div>
      </div>
    </div>
  </section>

  <script>
    const categoriesFromDB = <?php echo json_encode($categoriesFromDB); ?>;
    console.log(categoriesFromDB);

    // Cập nhật giao diện dựa trên trạng thái đăng nhập
    const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    const username = <?php echo json_encode($username); ?>;
    const loginBtn = document.getElementById('login-btn');
    const userInfo = document.getElementById('user-info');
    const usernameSpan = document.getElementById('username');

    if (isLoggedIn) {
      if (loginBtn) loginBtn.style.display = 'none';
      if (userInfo) {
        userInfo.classList.remove('hidden');
        usernameSpan.textContent = username;
      }
    } else {
      if (loginBtn) loginBtn.style.display = 'block';
      if (userInfo) userInfo.classList.add('hidden');
    }
  </script>
  <script src="public/js/scripts-home.js"></script>
</body>

</html>