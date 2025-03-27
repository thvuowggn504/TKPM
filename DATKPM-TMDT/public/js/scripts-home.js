document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.card');

    let autoRotateInterval;
    let restartTimeout;
    let isHovering = false;

    function startAutoRotate() {
        autoRotateInterval = setInterval(() => {
            if (!isHovering) {
                const rightCard = document.querySelector('.card[data-position="right"]');
                if (rightCard) rightCard.click();
            }
        }, 5000);
    }

    function stopAutoRotate() {
        clearInterval(autoRotateInterval);
        clearTimeout(restartTimeout);
    }

    function restartAutoRotate() {
        stopAutoRotate();
        restartTimeout = setTimeout(() => {
            isHovering = false;
            startAutoRotate();
        }, 5000);
    }

    // Bắt đầu auto xoay
    startAutoRotate();

    // Dừng auto xoay khi hover vào bất kỳ card nào
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            isHovering = true;
            stopAutoRotate();
        });

        card.addEventListener('mouseleave', () => {
            restartAutoRotate();
        });
    });

    // Xử lý hiệu ứng click để chuyển vị trí
    cards.forEach(card => {
        card.addEventListener('click', function () {
            const position = this.getAttribute('data-position');

            if (position !== 'center') {
                const leftCard = document.querySelector('.card[data-position="left"]');
                const centerCard = document.querySelector('.card[data-position="center"]');
                const rightCard = document.querySelector('.card[data-position="right"]');

                if (position === 'left') {
                    this.className = 'card center';
                    this.setAttribute('data-position', 'center');
                    centerCard.className = 'card right';
                    centerCard.setAttribute('data-position', 'right');
                    rightCard.className = 'card left';
                    rightCard.setAttribute('data-position', 'left');
                } else if (position === 'right') {
                    this.className = 'card center';
                    this.setAttribute('data-position', 'center');
                    centerCard.className = 'card left';
                    centerCard.setAttribute('data-position', 'left');
                    leftCard.className = 'card right';
                    leftCard.setAttribute('data-position', 'right');
                }
            }
        });
    });

    // Hiệu ứng 3D khi di chuột vào card ở giữa
    document.addEventListener('mousemove', function (e) {
        const centerCard = document.querySelector('.card.center');
        if (!centerCard) return;

        const rect = centerCard.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateY = (x - centerX) / 20;
            const rotateX = (centerY - y) / 20;
            centerCard.style.transform = `translateZ(10px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        } else {
            centerCard.style.transform = '';
        }
    });

    // Reset transform khi chuột rời khỏi màn hình
    document.addEventListener('mouseleave', function () {
        const centerCard = document.querySelector('.card.center');
        if (centerCard) {
            centerCard.style.transform = '';
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Danh sách các danh mục và sản phẩm tương ứng
    const categories = {
        "Mac": ["MacBook Air", "MacBook Pro", "iMac", "Mac Mini"],
        "Iphone": ["iPhone 13", "iPhone 14", "iPhone 15 Pro", "iPhone SE"],
        "Watch": ["Apple Watch Series 8", "Apple Watch Ultra", "Apple Watch SE"],
        "AirPods": ["AirPods 2", "AirPods 3", "AirPods Pro", "AirPods Max"]
    };

    let activeMenu = null;

    // Lấy danh sách tất cả các mục trong nav
    const navItems = document.querySelectorAll("nav a");

    navItems.forEach(item => {
        const categoryName = item.textContent.trim();
        if (categories[categoryName]) {
            // Tạo dropdown menu
            const dropdownMenu = document.createElement("div");
            dropdownMenu.classList.add("dropdown-menu");

            // Thêm danh sách sản phẩm
            categories[categoryName].forEach(product => {
                const productLink = document.createElement("a");
                productLink.href = "#";
                productLink.textContent = product;
                dropdownMenu.appendChild(productLink);
            });

            // Thêm menu vào body để nó đè lên toàn bộ nội dung
            document.body.appendChild(dropdownMenu);

            // Xử lý hover
            item.addEventListener("mouseenter", () => {
                if (activeMenu) {
                    activeMenu.classList.remove("active");
                }
                dropdownMenu.classList.add("active");
                activeMenu = dropdownMenu;
            });

            // Ẩn menu khi di chuột ra ngoài
            dropdownMenu.addEventListener("mouseleave", () => {
                dropdownMenu.classList.remove("active");
                activeMenu = null;
            });
        }
    });

    // Ẩn menu khi click ra ngoài
    document.addEventListener("click", (e) => {
        if (activeMenu && !e.target.closest(".dropdown-menu") && !e.target.closest("nav a")) {
            activeMenu.classList.remove("active");
            activeMenu = null;
        }
    });
});

//Search
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const dropdownSearch = document.getElementById("dropdown-search");

    // Hiển thị dropdown khi click vào ô tìm kiếm
    searchInput.addEventListener("focus", function () {
        dropdownSearch.classList.add("active");
    });

    // Ẩn dropdown khi click ra ngoài
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".search-container")) {
            dropdownSearch.classList.remove("active");
        }
    });

    // Ẩn chữ "Tìm kiếm sản phẩm" khi nhập
    searchInput.addEventListener("input", function () {
        if (searchInput.value.trim() === "") {
            searchInput.setAttribute("placeholder", "Tìm kiếm sản phẩm");
        } else {
            searchInput.setAttribute("placeholder", "");
        }
    });
});

// user
document.addEventListener("DOMContentLoaded", function () {
    const loginBtn = document.getElementById("login-btn");
    const userInfo = document.getElementById("user-info");
    const usernameSpan = document.getElementById("username");
    const userDropdown = document.querySelector(".user-dropdown");
    const logoutBtn = document.getElementById("logout-btn");

    // Lấy thông tin người dùng từ localStorage
    const currentUser = JSON.parse(localStorage.getItem("currentUser"));

    if (currentUser) {
        loginBtn.style.display = "none";
        userInfo.classList.remove("hidden");
        usernameSpan.textContent = currentUser.name;
    }

    // Hover để hiện dropdown
    userInfo.addEventListener("mouseenter", () => {
        userDropdown.style.display = "block";
    });

    userInfo.addEventListener("mouseleave", () => {
        userDropdown.style.display = "none";
    });

    // Xử lý đăng xuất
    logoutBtn.addEventListener("click", () => {
        localStorage.removeItem("currentUser");
        alert("Bạn đã đăng xuất!");
        window.location.reload();
    });
});




