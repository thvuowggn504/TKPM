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
