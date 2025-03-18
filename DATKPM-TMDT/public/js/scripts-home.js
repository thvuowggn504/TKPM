document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.card');

    // Add click event to each card
    cards.forEach(card => {
        card.addEventListener('click', function () {
            const position = this.getAttribute('data-position');

            // Only perform action if clicked card is not already in center
            if (position !== 'center') {
                // Get current positions
                const leftCard = document.querySelector('.card[data-position="left"]');
                const centerCard = document.querySelector('.card[data-position="center"]');
                const rightCard = document.querySelector('.card[data-position="right"]');

                if (position === 'left') {
                    // Left card moves to center
                    this.className = 'card center';
                    this.setAttribute('data-position', 'center');

                    // Center card moves to right
                    centerCard.className = 'card right';
                    centerCard.setAttribute('data-position', 'right');

                    // Right card moves to left
                    rightCard.className = 'card left';
                    rightCard.setAttribute('data-position', 'left');
                } else if (position === 'right') {
                    // Right card moves to center
                    this.className = 'card center';
                    this.setAttribute('data-position', 'center');

                    // Center card moves to left
                    centerCard.className = 'card left';
                    centerCard.setAttribute('data-position', 'left');

                    // Left card moves to right
                    leftCard.className = 'card right';
                    leftCard.setAttribute('data-position', 'right');
                }
            }
        });
    });

    // Add 3D effect only for center card
    document.addEventListener('mousemove', function (e) {
        const centerCard = document.querySelector('.card.center');
        if (!centerCard) return;

        const rect = centerCard.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        // Check if mouse is over the center card
        if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            // Calculate rotation values
            const rotateY = (x - centerX) / 20;
            const rotateX = (centerY - y) / 20;

            // Apply 3D transform
            centerCard.style.transform = `translateZ(10px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        } else {
            // Reset when mouse leaves
            centerCard.style.transform = '';
        }
    });

    // Reset transform when mouse leaves the document
    document.addEventListener('mouseleave', function () {
        const centerCard = document.querySelector('.card.center');
        if (centerCard) {
            centerCard.style.transform = '';
        }
    });

    // Auto rotation
    let autoRotateInterval;

    function startAutoRotate() {
        autoRotateInterval = setInterval(() => {
            const rightCard = document.querySelector('.card[data-position="right"]');
            rightCard.click();
        }, 5000); // Rotate every 5 seconds
    }

    // Start auto-rotation
    startAutoRotate();

    // Stop auto-rotation when user interacts
    cards.forEach(card => {
        card.addEventListener('click', () => {
            clearInterval(autoRotateInterval);

            // Restart after 10 seconds of inactivity
            setTimeout(() => {
                startAutoRotate();
            }, 10000);
        });
    });
});